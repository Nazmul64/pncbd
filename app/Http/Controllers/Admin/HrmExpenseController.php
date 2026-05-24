<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmExpense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HrmExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-expenses');
    }

    /**
     * Display a listing of expenses.
     */
    public function index(Request $request)
    {
        $query = HrmExpense::query();

        // Check if custom date range is provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);

            $year = null;
            $month = null;
        } else {
            // Default to monthly view
            $year = (int) $request->input('year', Carbon::now()->year);
            $month = (int) $request->input('month', Carbon::now()->month);
            $query->whereYear('date', $year)->whereMonth('date', $month);

            $startDate = null;
            $endDate = null;
        }

        // Keep a copy of the query for totals before paginating
        $totalExpenses = (float) $query->sum('amount');

        $expenses = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        return view('admin.hrm.expenses.index', compact(
            'expenses',
            'year',
            'month',
            'startDate',
            'endDate',
            'totalExpenses'
        ));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $date = Carbon::parse($request->date);

        HrmExpense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.hrm.expenses.index', [
            'year' => $date->year,
            'month' => $date->month
        ])->with('success', 'Expense recorded successfully!');
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = HrmExpense::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $date = Carbon::parse($request->date);

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.hrm.expenses.index', [
            'year' => $date->year,
            'month' => $date->month
        ])->with('success', 'Expense details updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy($id)
    {
        $expense = HrmExpense::findOrFail($id);
        $date = Carbon::parse($expense->date);
        $expense->delete();

        return redirect()->route('admin.hrm.expenses.index', [
            'year' => $date->year,
            'month' => $date->month
        ])->with('success', 'Expense log deleted successfully.');
    }
}
