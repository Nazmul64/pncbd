<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmEmployee;
use App\Models\HrmSalaryAdvance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HrmSalaryAdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-salary-advance');
    }

    /**
     * Display salary advances ledger and payroll calculator.
     */
    public function index(Request $request)
    {
        $year = (int) $request->input('year', Carbon::now()->year);
        $month = (int) $request->input('month', Carbon::now()->month);

        // Fetch employees to choose from inside the modal form
        $employeesList = HrmEmployee::where('status', 'active')->orderBy('name', 'asc')->get();

        // Calculate pay slips for the month
        $paySlips = [];
        foreach ($employeesList as $employee) {
            $baseSalary = (float) $employee->salary;
            $advanceTaken = $employee->getAdvanceAmountForMonth($year, $month);
            $netPayable = $employee->getNetPayableForMonth($year, $month);

            $paySlips[] = [
                'employee' => $employee,
                'base_salary' => $baseSalary,
                'advance_taken' => $advanceTaken,
                'net_payable' => $netPayable,
            ];
        }

        // Get detailed history of advance payments for this month
        $advances = HrmSalaryAdvance::with('employee')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Statistics for summary cards
        $stats = [
            'total_base_salary' => HrmEmployee::where('status', 'active')->sum('salary'),
            'total_advances_month' => HrmSalaryAdvance::whereYear('date', $year)->whereMonth('date', $month)->sum('amount'),
        ];
        $stats['total_net_payable'] = max(0.00, $stats['total_base_salary'] - $stats['total_advances_month']);

        return view('admin.hrm.advance-salary.index', compact(
            'employeesList',
            'paySlips',
            'advances',
            'year',
            'month',
            'stats'
        ));
    }

    /**
     * Store a newly created salary advance record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'exists:hrm_employees,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $employee = HrmEmployee::findOrFail($request->employee_id);
        $date = Carbon::parse($request->date);

        // Check if advance exceeds the base salary of the employee for the given month
        $existingAdvances = $employee->getAdvanceAmountForMonth($date->year, $date->month);
        $requestedAmount = (float) $request->amount;

        if (($existingAdvances + $requestedAmount) > (float) $employee->salary) {
            return back()->with('error', "Cannot disburse advance salary. Total advances ({$existingAdvances} + {$requestedAmount} = " . ($existingAdvances + $requestedAmount) . ") exceeds the employee's base salary ({$employee->salary}) for " . $date->format('F Y') . "!");
        }

        HrmSalaryAdvance::create([
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.hrm.advance-salaries.index', [
            'year' => $date->year,
            'month' => $date->month
        ])->with('success', 'Salary advance has been recorded successfully.');
    }

    /**
     * Remove the specified salary advance record from storage.
     */
    public function destroy($id)
    {
        $advance = HrmSalaryAdvance::findOrFail($id);
        $date = Carbon::parse($advance->date);
        $advance->delete();

        return redirect()->route('admin.hrm.advance-salaries.index', [
            'year' => $date->year,
            'month' => $date->month
        ])->with('success', 'Salary advance record has been successfully deleted.');
    }
}
