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

        // 3. Fetch all approved loans with user details and NID information for certificate generator
        $approvedLoansList = Loan::with(['user.information'])->where('status', 'approved')->orderBy('id', 'desc')->get();

        // 4. Get the latest admin-uploaded stamp image
        $dirPath = public_path('uploads/information');
        $activeStampUrl = null;
        if (file_exists($dirPath)) {
            $files = array_diff(scandir($dirPath), ['.', '..']);
            $stampFiles = [];
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                // Exclude customer uploads (selfie, nid, other, signature, receipt, stamp_contract)
                if (is_file($filePath) && 
                    !str_contains($file, '_selfie_') && 
                    !str_contains($file, '_nid_front_') && 
                    !str_contains($file, '_nid_back_') && 
                    !str_contains($file, '_other_doc_') && 
                    !str_contains($file, '_stamp_contract_') && 
                    !str_contains($file, '_signature_') &&
                    !str_contains($file, '_receipt_') &&
                    @getimagesize($filePath)) {
                    $stampFiles[$file] = filemtime($filePath);
                }
            }
            if (!empty($stampFiles)) {
                arsort($stampFiles);
                $latestFile = key($stampFiles);
                $activeStampUrl = asset('uploads/information/' . $latestFile);
            }
        }

        return view('emplee.index', compact(
            'pendingLoans',
            'approvedLoans',
            'rejectedLoans',
            'totalLoans',
            'totalUsers',
            'searchResult',
            'approvedLoansList',
            'activeStampUrl'
        ));
    }

    // ── Stamp Page (আলাদা পেজ, modal নয়) ─────────────────────────
    public function stampPage()
    {
        // সকল approved loan with user info
        $approvedLoansList = Loan::with(['user.information'])
            ->where('status', 'approved')
            ->orderBy('id', 'desc')
            ->get();

        // Latest admin stamp image
        $dirPath       = public_path('uploads/information');
        $activeStampUrl = null;
        if (file_exists($dirPath)) {
            $files      = array_diff(scandir($dirPath), ['.', '..']);
            $stampFiles = [];
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                if (is_file($filePath) &&
                    !str_contains($file, '_selfie_') &&
                    !str_contains($file, '_nid_front_') &&
                    !str_contains($file, '_nid_back_') &&
                    !str_contains($file, '_other_doc_') &&
                    !str_contains($file, '_stamp_contract_') &&
                    !str_contains($file, '_signature_') &&
                    !str_contains($file, '_receipt_') &&
                    @getimagesize($filePath)) {
                    $stampFiles[$file] = filemtime($filePath);
                }
            }
            if (!empty($stampFiles)) {
                arsort($stampFiles);
                $latestFile    = key($stampFiles);
                $activeStampUrl = asset('uploads/information/' . $latestFile);
            }
        }

        // Site logo & name
        $gs       = \App\Models\Generalsetting::getSettings();
        $siteLogo = $gs->header_logo ? asset($gs->header_logo) : null;
        $siteName = $gs->site_name ?? 'Pncbd';

        return view('emplee.stamp', compact('approvedLoansList', 'activeStampUrl', 'siteLogo', 'siteName'));
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

        // Phone দিয়ে user খুঁজি (Auth::attempt phone সরাসরি support করে না)
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'phone' => 'ভুল ফোন নম্বর বা পাসওয়ার্ড প্রদান করা হয়েছে।',
            ])->withInput();
        }

        // 1. Suspension & Inactivity Check
        if (in_array($user->status, ['suspended', 'inactive'])) {
            return back()->withErrors([
                'phone' => 'আপনার অ্যাকাউন্টটি স্থগিত (Suspended) বা নিষ্ক্রিয় (Inactive) করা হয়েছে। অনুগ্রহ করে অ্যাডমিনের সাথে যোগাযোগ করুন।',
            ])->withInput();
        }

        // 2. Role Access Check (must be a staff member)
        if (!$user->canAccessAdmin()) {
            return back()->withErrors([
                'phone' => 'আপনার স্টাফ প্যানেলে অ্যাক্সেস করার অনুমতি নেই।',
            ])->withInput();
        }

        // 3. Manual login
        Auth::login($user, false);
        $request->session()->regenerate();

        // Redirect based on user's highest role
        return $this->redirectBasedOnRole($user)
            ->with('success', 'স্বাগতম, ' . $user->name . '! স্টাফ প্যানেলে সফলভাবে লগইন করেছেন।');
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
        $previousStatus = $loan->status;
        $newStatus = $request->status;

        // ── Balance Logic ──────────────────────────────────────────────────────
        if ($newStatus === 'approved' && $previousStatus !== 'approved') {
            // নতুন Approve — balance বাড়াও
            User::where('id', $loan->user_id)->increment('balance', $loan->amount);
        } elseif ($previousStatus === 'approved' && in_array($newStatus, ['rejected', 'pending'])) {
            // Approve বাতিল — balance কমাও
            $user = User::find($loan->user_id);
            if ($user && $user->balance >= $loan->amount) {
                $user->decrement('balance', $loan->amount);
            } else {
                User::where('id', $loan->user_id)->update(['balance' => 0]);
            }
        }

        $loan->status = $newStatus;
        $loan->save();

        return back()->with('success', 'লোন আইডি #' . $loan->id . ' এর স্থিতি সফলভাবে "' . ucfirst($newStatus) . '" করা হয়েছে।');
    }

    // Update Customer Profile Details
    public function updateCustomerProfile(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $id,
            'phone'             => 'required|string|unique:users,phone,' . $id,
            'address'           => 'nullable|string',
            'balance'           => 'nullable|numeric|min:0',
            'nid_number'        => 'nullable|string|max:50',
            'occupation'        => 'nullable|string|max:255',
            'current_address'   => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'loan_reason'       => 'nullable|string',
            'nominee_name'      => 'nullable|string|max:255',
            'nominee_relation'  => 'nullable|string|max:255',
            'nominee_phone'     => 'nullable|string|max:50',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'balance' => $request->balance ?? 0,
        ]);

        $user->information()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name'         => $request->name,
                'phone_number'      => $request->phone,
                'nid_number'        => $request->nid_number,
                'occupation'        => $request->occupation,
                'current_address'   => $request->current_address,
                'permanent_address' => $request->permanent_address,
                'loan_reason'       => $request->loan_reason,
                'nominee_name'      => $request->nominee_name,
                'nominee_relation'  => $request->nominee_relation,
                'nominee_phone'     => $request->nominee_phone,
            ]
        );

        return back()->with('success', 'গ্রাহকের প্রোফাইল তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    // Change Customer Password directly
    public function changeCustomerPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('success', 'গ্রাহকের পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে।');
    }
}
