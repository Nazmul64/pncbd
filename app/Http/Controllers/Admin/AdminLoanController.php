<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Log;

class AdminLoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Loan::with('user', 'bank')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_number', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('bank', function($bankQ) use ($search) {
                      $bankQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.index', compact('loans'));
    }

    public function show($id)
    {
        $loan = Loan::with('user', 'bank')->findOrFail($id);
        return view('admin.loans.show', compact('loan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->status = $request->status;
        $loan->save();

        return redirect()->route('admin.loans.show', $loan->id)
            ->with('success', 'ঋণ আবেদনের স্থিতি সফলভাবে পরিবর্তন করা হয়েছে।');
    }
    /**
     * Display all loan applications (pending loans)
     */
    public function loanApplications(Request $request)
    {
        $query = Loan::with('user', 'bank')->where('status', 'pending')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_number', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('bank', function($bankQ) use ($search) {
                      $bankQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.applications', compact('loans'));
    }

    /**
     * Display all loan approvals (approved loans)
     */
    public function loanApprovals(Request $request)
    {
        $query = Loan::with('user', 'bank')->where('status', 'approved')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_number', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('bank', function($bankQ) use ($search) {
                      $bankQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.approvals', compact('loans'));
    }

    /**
     * Display bank check approvals
     */
    public function bankCheckApprovals(Request $request)
    {
        $query = Loan::with('user', 'bank')
            ->whereNotNull('bank_id')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('account_number', 'like', "%{$search}%")
                  ->orWhereHas('bank', function($bankQ) use ($search) {
                      $bankQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.bank-check-approvals', compact('loans'));
    }}
