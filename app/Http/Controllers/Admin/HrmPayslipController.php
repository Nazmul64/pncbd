<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmEmployee;
use App\Models\HrmAttendance;
use App\Models\HrmLeave;
use App\Models\HrmPayslip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HrmPayslipController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-salary-advance');
    }

    /**
     * Display generated payslips index for a selected month/year.
     */
    public function index(Request $request)
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $month = (int) $request->input('month', Carbon::now()->month);

        $payslips = HrmPayslip::with('employee')
            ->where('year', $year)
            ->where('month', $month)
            ->get();

        $employees = HrmEmployee::where('status', 'active')->get();

        // Calculate global summary stats for the filtered month
        $totalBaseSalary = $payslips->sum('base_salary');
        $totalNetSalary = $payslips->sum('net_salary');
        $totalPaidCount = $payslips->where('status', 'paid')->count();
        $totalPendingCount = $payslips->where('status', 'pending')->count();

        return view('admin.hrm.payslips.index', compact(
            'payslips',
            'employees',
            'year',
            'month',
            'totalBaseSalary',
            'totalNetSalary',
            'totalPaidCount',
            'totalPendingCount'
        ));
    }

    /**
     * Bulk generate payslips for all active employees for the selected month/year.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'year' => ['required', 'integer'],
            'month' => ['required', 'integer', 'between:1,12'],
        ]);

        $year = (int) $request->year;
        $month = (int) $request->month;

        $employees = HrmEmployee::where('status', 'active')->get();
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        DB::beginTransaction();
        try {
            foreach ($employees as $employee) {
                // Calculate Present & Absent counts from attendance logs
                $presentDays = HrmAttendance::where('employee_id', $employee->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->where('status', 'present')
                    ->count();

                $absentDays = HrmAttendance::where('employee_id', $employee->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->where('status', 'absent')
                    ->count();

                // Calculate Leave Days (Approved leaves matching this month)
                $leaveDays = 0;
                $leaves = HrmLeave::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->where(function ($query) use ($year, $month) {
                        $query->whereYear('start_date', $year)->whereMonth('start_date', $month)
                           ->orWhereYear('end_date', $year)->whereMonth('end_date', $month);
                    })->get();

                foreach ($leaves as $leave) {
                    $start = Carbon::parse($leave->start_date);
                    $end = Carbon::parse($leave->end_date);
                    
                    // Loop through days in leave and count those in the target month
                    for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                        if ($d->year === $year && $d->month === $month) {
                            $leaveDays++;
                        }
                    }
                }

                // Advances drawn
                $advances = $employee->getAdvanceAmountForMonth($year, $month);

                // Auto Deduction: deduct base salary per absent day (International standard!)
                // Leave days are not deducted as they are approved leaves!
                $deductions = round(($employee->salary / $daysInMonth) * $absentDays, 2);

                // Default Net Salary
                $netSalary = max(0.00, $employee->salary - $advances - $deductions);

                // Check if payslip already exists
                $existing = HrmPayslip::where('employee_id', $employee->id)
                    ->where('year', $year)
                    ->where('month', $month)
                    ->first();

                if ($existing) {
                    // Do not overwrite a paid payslip to avoid audit mismatches
                    if ($existing->status === 'paid') {
                        continue;
                    }

                    $existing->update([
                        'base_salary' => $employee->salary,
                        'present_days' => $presentDays,
                        'absent_days' => $absentDays,
                        'leave_days' => $leaveDays,
                        'advances_drawn' => $advances,
                        'deductions' => $deductions,
                        'net_salary' => $netSalary,
                    ]);
                } else {
                    HrmPayslip::create([
                        'employee_id' => $employee->id,
                        'month' => $month,
                        'year' => $year,
                        'base_salary' => $employee->salary,
                        'present_days' => $presentDays,
                        'absent_days' => $absentDays,
                        'leave_days' => $leaveDays,
                        'advances_drawn' => $advances,
                        'bonus' => 0.00,
                        'deductions' => $deductions,
                        'net_salary' => $netSalary,
                        'status' => 'pending',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.hrm.payslips.index', ['year' => $year, 'month' => $month])
                ->with('success', "Payslips for " . Carbon::create(null, $month, 1)->format('F') . " {$year} generated successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error generating payslips: ' . $e->getMessage());
        }
    }

    /**
     * Mark a specific payslip as paid.
     */
    public function pay(Request $request, $id)
    {
        $request->validate([
            'payment_method' => ['required', 'string', 'in:Cash,bKash,Bank Transfer,Nagad,Rocket'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'custom_deductions' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $payslip = HrmPayslip::findOrFail($id);

        if ($payslip->status === 'paid') {
            return back()->with('error', 'This payslip has already been paid.');
        }

        $bonus = (float) $request->input('bonus', 0);
        $customDeductions = (float) $request->input('custom_deductions', 0);

        // Recalculate net salary: net = base - advances - auto_deductions - custom_deductions + bonus
        $net = max(0.00, $payslip->base_salary - $payslip->advances_drawn - $payslip->deductions - $customDeductions + $bonus);

        $payslip->update([
            'bonus' => $bonus,
            'deductions' => $payslip->deductions + $customDeductions,
            'net_salary' => $net,
            'status' => 'paid',
            'paid_at' => Carbon::now(),
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Payslip marked as paid successfully!');
    }

    /**
     * Render print view for a specific payslip.
     */
    public function print($id)
    {
        $payslip = HrmPayslip::with('employee')->findOrFail($id);
        return view('admin.hrm.payslips.print', compact('payslip'));
    }

    /**
     * Delete a specific payslip.
     */
    public function destroy($id)
    {
        $payslip = HrmPayslip::findOrFail($id);
        if ($payslip->status === 'paid') {
            return back()->with('error', 'Cannot delete a paid payslip.');
        }
        $payslip->delete();
        return back()->with('success', 'Payslip deleted successfully.');
    }
}
