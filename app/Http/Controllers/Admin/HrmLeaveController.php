<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmEmployee;
use App\Models\HrmLeave;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HrmLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-attendance');
    }

    /**
     * Display a listing of leaves.
     */
    public function index()
    {
        $leaves = HrmLeave::with('employee')->orderBy('start_date', 'desc')->paginate(15);
        $employees = HrmEmployee::where('status', 'active')->orderBy('name', 'asc')->get();

        // Calculate summary cards
        $pendingCount = HrmLeave::where('status', 'pending')->count();
        $approvedCount = HrmLeave::where('status', 'approved')->count();
        $thisMonthCount = HrmLeave::whereYear('start_date', Carbon::now()->year)
            ->whereMonth('start_date', Carbon::now()->month)
            ->where('status', 'approved')
            ->count();

        return view('admin.hrm.leaves.index', compact('leaves', 'employees', 'pendingCount', 'approvedCount', 'thisMonthCount'));
    }

    /**
     * Store a newly created leave.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', 'exists:hrm_employees,id'],
            'leave_type' => ['required', 'string', 'in:casual,sick,emergency,unpaid'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        HrmLeave::create($request->all());

        return redirect()->route('admin.hrm.leaves.index')->with('success', 'Leave record created successfully!');
    }

    /**
     * Update the specified leave.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => ['required', 'exists:hrm_employees,id'],
            'leave_type' => ['required', 'string', 'in:casual,sick,emergency,unpaid'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $leave = HrmLeave::findOrFail($id);
        $leave->update($request->all());

        return redirect()->route('admin.hrm.leaves.index')->with('success', 'Leave record updated successfully!');
    }

    /**
     * Remove the specified leave.
     */
    public function destroy($id)
    {
        $leave = HrmLeave::findOrFail($id);
        $leave->delete();

        return redirect()->route('admin.hrm.leaves.index')->with('success', 'Leave record deleted successfully!');
    }
}
