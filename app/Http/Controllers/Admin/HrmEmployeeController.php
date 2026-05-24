<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HrmEmployeeController extends Controller
{
    public function __construct()
    {
        // Require corresponding permissions
        $this->middleware('permission:view-employees')->only(['index', 'show']);
        $this->middleware('permission:create-employees')->only(['create', 'store']);
        $this->middleware('permission:edit-employees')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete-employees')->only(['destroy']);
    }

    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = HrmEmployee::query();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('nid_number', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // Calculate statistics for index cards
        $stats = [
            'total' => HrmEmployee::count(),
            'active' => HrmEmployee::where('status', 'active')->count(),
            'inactive' => HrmEmployee::where('status', 'inactive')->count(),
            'total_payroll' => HrmEmployee::where('status', 'active')->sum('salary'),
        ];

        return view('admin.hrm.employees.index', compact('employees', 'stats'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.hrm.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'nid_number' => ['required', 'string', 'max:50'],
            'salary' => ['required', 'numeric', 'min:0'],
            'employee_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_phone' => ['nullable', 'string', 'max:20'],
            'father_nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'mother_phone' => ['nullable', 'string', 'max:20'],
            'mother_nid_number' => ['nullable', 'string', 'max:50'],
            'mother_nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'parents_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'address' => ['nullable', 'string'],
            'district' => ['nullable', 'string', 'max:100'],
            'thana' => ['nullable', 'string', 'max:100'],
        ]);

        $data = $request->except(['employee_image', 'nid_image', 'father_nid_image', 'mother_nid_image', 'parents_image']);

        // Upload files directly to public_path('uploads/hrm')
        $this->ensureUploadDirectoryExists();

        $fileFields = ['employee_image', 'nid_image', 'father_nid_image', 'mother_nid_image', 'parents_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/hrm'), $filename);
                $data[$field] = 'uploads/hrm/' . $filename;
            }
        }

        HrmEmployee::create($data);

        return redirect()->route('admin.hrm.employees.index')
            ->with('success', 'Employee registered successfully!');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $employee = HrmEmployee::findOrFail($id);
        return view('admin.hrm.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = HrmEmployee::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'nid_number' => ['required', 'string', 'max:50'],
            'salary' => ['required', 'numeric', 'min:0'],
            'employee_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_phone' => ['nullable', 'string', 'max:20'],
            'father_nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'mother_phone' => ['nullable', 'string', 'max:20'],
            'mother_nid_number' => ['nullable', 'string', 'max:50'],
            'mother_nid_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'parents_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'address' => ['nullable', 'string'],
            'district' => ['nullable', 'string', 'max:100'],
            'thana' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data = $request->except(['employee_image', 'nid_image', 'father_nid_image', 'mother_nid_image', 'parents_image']);

        $this->ensureUploadDirectoryExists();

        $fileFields = ['employee_image', 'nid_image', 'father_nid_image', 'mother_nid_image', 'parents_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($employee->{$field} && File::exists(public_path($employee->{$field}))) {
                    File::delete(public_path($employee->{$field}));
                }

                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/hrm'), $filename);
                $data[$field] = 'uploads/hrm/' . $filename;
            }
        }

        $employee->update($data);

        return redirect()->route('admin.hrm.employees.index')
            ->with('success', 'Employee details updated successfully!');
    }

    /**
     * Toggle active status of employee.
     */
    public function toggleStatus($id)
    {
        $employee = HrmEmployee::findOrFail($id);
        $employee->status = $employee->status === 'active' ? 'inactive' : 'active';
        $employee->save();

        return response()->json([
            'success' => true,
            'status' => $employee->status,
            'message' => 'Employee status updated successfully!'
        ]);
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        $employee = HrmEmployee::findOrFail($id);

        // Delete all associated files
        $fileFields = ['employee_image', 'nid_image', 'father_nid_image', 'mother_nid_image', 'parents_image'];
        foreach ($fileFields as $field) {
            if ($employee->{$field} && File::exists(public_path($employee->{$field}))) {
                File::delete(public_path($employee->{$field}));
            }
        }

        $employee->delete();

        return redirect()->route('admin.hrm.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Ensure the upload directory exists under public folder.
     */
    private function ensureUploadDirectoryExists()
    {
        $path = public_path('uploads/hrm');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }
}
