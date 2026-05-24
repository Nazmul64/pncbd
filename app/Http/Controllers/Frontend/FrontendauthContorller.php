<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FrontendauthContorller extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // FRONTEND — show homepage
    // Route: GET /  → name: frontend
    // ─────────────────────────────────────────────────────────────────────────
    public function frontend()
    {
        return view('frontend.index');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REGISTER — show form
    // Route: GET customer/register  → name: customer.register
    // ─────────────────────────────────────────────────────────────────────────
    public function customerregister()
    {
        return view('frontend.login.register');
    }

    // routes.php এ duplicate GET route আছে তাই alias method ও দরকার
    public function customer_register()
    {
        return view('frontend.login.register');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REGISTER — handle submit
    // Route: POST customer/register  → name: customer.register.submit
    // ─────────────────────────────────────────────────────────────────────────
    public function customer_register_submit(Request $request)
    {
        $phone = $this->normalizePhone($request->input('phone', ''));
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => ['required', 'regex:/^01[3-9]\d{8}$/', 'unique:users,phone'],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'অনুগ্রহ করে আপনার নাম লিখুন।',
            'phone.required'     => 'অনুগ্রহ করে ফোন নম্বর দিন।',
            'phone.regex'        => 'সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন (০১ দিয়ে শুরু)।',
            'phone.unique'       => 'এই ফোন নম্বর দিয়ে ইতিমধ্যে অ্যাকাউন্ট আছে।',
            'password.min'       => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড দুটি মিলছে না।',
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'phone'    => $phone,
                'email'    => $phone . '@ubs.customer',
                'password' => Hash::make($request->password),
            ]);

            // Auto-assign customer role
            $user->assignRole('customer');

            Auth::login($user);

            return redirect()->route('customer.dashboard')
                ->with('success', 'রেজিস্ট্রেশন সফল হয়েছে! স্বাগতম।');

        } catch (\Exception $e) {
            Log::error('Customer Registration Error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'রেজিস্ট্রেশন ব্যর্থ হয়েছে, আবার চেষ্টা করুন।'])
                ->withInput();
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LOGIN — show form
    // Route: GET customer/login  → name: customer.login
    // ─────────────────────────────────────────────────────────────────────────
    public function customerlogin(Request $request)
    {
        return view('frontend.login.login');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LOGIN — handle submit
    // Route: POST customer/login/submit  → name: customer.login.submit
    // ─────────────────────────────────────────────────────────────────────────
    public function customer_login_submit(Request $request)
    {
        $request->validate([
            'phone'    => 'required',
            'password' => 'required|string|min:6',
        ], [
            'phone.required'    => 'ফোন নম্বর দিন।',
            'password.required' => 'পাসওয়ার্ড দিন।',
            'password.min'      => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
        ]);

        $phone = $this->normalizePhone($request->phone);
        $user = User::where('phone', $phone)->first();

        // পুরানো অ্যাকাউন্ট: ইমেইল দিয়ে রেজিস্ট্রেশন করা থাকলে
        if (!$user) {
            $user = User::where('email', $request->phone)->first();
        }

        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->hasRole('customer')) {
                $user->assignRole('customer');
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'সফলভাবে লগইন হয়েছে।');
        }

        return back()
            ->withErrors(['phone' => 'ফোন নম্বর বা পাসওয়ার্ড সঠিক নয়।'])
            ->withInput($request->only('phone'));
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '880') && strlen($digits) === 13) {
            $digits = '0' . substr($digits, 3);
        }

        return $digits;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LOGOUT
    // Route: POST customer/logout  → name: customer.logout
    // ─────────────────────────────────────────────────────────────────────────
    public function customer_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'সফলভাবে লগআউট হয়েছে।');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CUSTOMER DASHBOARD
    // Route: GET customer/dashboard  → name: customer.dashboard (protected by middleware)
    // ─────────────────────────────────────────────────────────────────────────
    public function user_dashboard(Request $request)
    {
        $user = auth()->user();

        // নিশ্চিত করো কাস্টমার role আছে
        if (!$user || !$user->hasRole('customer')) {
            auth()->logout();
            return redirect()->route('customer.login')
                ->with('error', 'আপনার অ্যাক্সেস নেই। লগইন করুন।');
        }

        $loans = \App\Models\Loan::where('user_id', $user->id)->latest()->get();
        return view('userdashboard.index', compact('user', 'loans'));
    }

    /**
     * Show customer member card view
     */
    public function user_card()
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole('customer')) {
            auth()->logout();
            return redirect()->route('customer.login')
                ->with('error', 'আপনার অ্যাক্সেস নেই। লগইন করুন।');
        }

        return view('userdashboard.card', compact('user'));
    }
}
