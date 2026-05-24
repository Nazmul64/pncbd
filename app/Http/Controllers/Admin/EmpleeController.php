<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleeController extends Controller
{
    // Employee Dashboard
    public function emplee_dashboard(Request $request)
    {
        // 1. Fetch dynamic metrics
        $pendingLoans  = Loan::where('status', 'pending')->count();
        $approvedLoans = Loan::where('status', 'approved')->count();
        $rejectedLoans = Loan::where('status', 'rejected')->count();
        $totalLoans    = Loan::count();
        $totalUsers    = User::whereHas('roles', function($q) {
            $q->where('slug', 'customer');
        })->count();

        // 2. Perform Customer Phone Search if requested
        $searchResult = null;
        if ($request->filled('phone')) {
            $searchResult = User::with(['loans', 'information'])
                ->where('phone', $request->phone)
                ->first();
        }

        return view('emplee.index', compact(
            'pendingLoans',
            'approvedLoans',
            'rejectedLoans',
            'totalLoans',
            'totalUsers',
            'searchResult'
        ));
    }

    // Show Login Page
    public function emplee()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isActive() && $user->canAccessAdmin()) {
                return $this->redirectBasedOnRole($user);
            }
        }

        // Fetch active staff members to show in the right card of the login page
        $staffMembers = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['super-admin', 'admin', 'sub-admin', 'manager', 'employee']);
        })->where('status', 'active')->orderBy('name')->take(10)->get();

        return view('emplee.auth.login', compact('staffMembers'));
    }

    // Login Submit using Phone Number & Password
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 1. Suspension & Inactivity Check
            if (in_array($user->status, ['suspended', 'inactive'])) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'phone' => 'আপনার অ্যাকাউন্টটি স্থগিত (Suspended) বা নিষ্ক্রিয় (Inactive) করা হয়েছে। অনুগ্রহ করে অ্যাডমিনের সাথে যোগাযোগ করুন।',
                ])->withInput();
            }

            // 2. Role Access Check (must be a staff member)
            if (!$user->canAccessAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'phone' => 'আপনার স্টাফ প্যানেলে অ্যাক্সেস করার অনুমতি নেই।',
                ])->withInput();
            }

            $request->session()->regenerate();

            // Redirect based on user's highest role
            return $this->redirectBasedOnRole($user)
                ->with('success', 'স্বাগতম, ' . $user->name . '! স্টাফ প্যানেলে সফলভাবে লগইন করেছেন।');
        }

        return back()->withErrors([
            'phone' => 'ভুল ফোন নম্বর বা পাসওয়ার্ড প্রদান করা হয়েছে।',
        ])->withInput();
    }

    // Dynamic redirect based on user roles
    protected function redirectBasedOnRole($user)
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSubAdmin()) {
            return redirect()->route('admin.subadmin.dashboard');
        } elseif ($user->isManager()) {
            return redirect()->route('admin.manager.dashboard');
        } elseif ($user->isEmployee()) {
            return redirect()->route('admin.emplee.dashboard');
        }

        return redirect()->to('/');
    }

    // Logout
    public function emplee_logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('emplee.login')
            ->with('success', 'সফলভাবে লগআউট করা হয়েছে।');
    }

    // Staff Loan Status Update (Approve or Reject directly from dashboard search)
    public function updateLoanStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->status = $request->status;
        $loan->save();

        return back()->with('success', 'লোন আইডি #' . $loan->id . ' এর স্থিতি সফলভাবে "' . ucfirst($request->status) . '" করা হয়েছে।');
    }
}
