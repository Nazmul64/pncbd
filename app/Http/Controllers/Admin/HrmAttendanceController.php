<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmEmployee;
use App\Models\HrmAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HrmAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-attendance');
    }

    /**
     * Display the monthly attendance checklist grid.
     */
    public function index(Request $request)
    {
        // Default to current year and month if not provided
        $year = (int) $request->input('year', Carbon::now()->year);
        $month = (int) $request->input('month', Carbon::now()->month);

        $employees = HrmEmployee::where('status', 'active')->orderBy('name', 'asc')->get();

        // Calculate days in the selected month
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // Fetch existing attendance logs for the month
        $attendanceRecords = HrmAttendance::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Group attendance by employee ID and day of the month for fast O(1) lookup
        $attendanceGrid = [];
        foreach ($attendanceRecords as $record) {
            $day = (int) $record->date->format('d');
            $attendanceGrid[$record->employee_id][$day] = $record->status;
        }

        // Generate dynamic lists for history summaries per employee
        $employeeHistory = [];
        foreach ($employees as $employee) {
            $presentCount = HrmAttendance::where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'present')
                ->count();

            $absentCount = HrmAttendance::where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'absent')
                ->count();

            $employeeHistory[$employee->id] = [
                'present' => $presentCount,
                'absent' => $absentCount
            ];
        }

        return view('admin.hrm.attendance.index', compact(
            'employees',
            'year',
            'month',
            'daysInMonth',
            'attendanceGrid',
            'employeeHistory'
        ));
    }

    /**
     * Save the attendance grid.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => ['required', 'integer'],
            'month' => ['required', 'integer', 'between:1,12'],
        ]);

        $year = (int) $request->year;
        $month = (int) $request->month;

        $employees = HrmEmployee::where('status', 'active')->get();
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // Extract submitted data: format is attendance[employee_id][day_number] = 'present'
        $submittedAttendance = $request->input('attendance', []);

        DB::beginTransaction();
        try {
            foreach ($employees as $employee) {
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    // Formulate full date
                    $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

                    $status = ($submittedAttendance[$employee->id][$day] ?? 'absent') === 'present' ? 'present' : 'absent';

                    HrmAttendance::updateOrCreate(
                        [
                            'employee_id' => $employee->id,
                            'date' => $date
                        ],
                        [
                            'status' => $status
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->route('admin.hrm.attendance.index', ['year' => $year, 'month' => $month])
                ->with('success', 'Attendance sheets saved and updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error occurred while saving attendance: ' . $e->getMessage());
        }
    }
}
