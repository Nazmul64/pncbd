<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bank;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function step1()
    {
        $sessionData = session('loan_application', []);
        $banks = Bank::where('is_active', true)->orderBy('name')->get();

        return view('loan.step1', compact('sessionData', 'banks'));
    }

    public function postStep1(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:bikash,nagad,bank',
        ], [
            'payment_method.required' => 'অনুগ্রহ করে পেমেন্ট পদ্ধতি নির্বাচন করুন।',
        ]);

        if ($request->payment_method === 'bank') {
            $request->validate([
                'account_holder_name' => 'required|string|max:255',
                'account_number'      => 'required|string|max:255',
                'bank_id'             => ['required', 'integer', Rule::exists('banks', 'id')->where('is_active', 1)],
                'branch'              => 'required|string|max:255',
            ], [
                'account_holder_name.required' => 'অ্যাকাউন্ট হোল্ডারের নাম আবশ্যক।',
                'account_number.required'      => 'অ্যাকাউন্ট নম্বর আবশ্যক।',
                'bank_id.required'             => 'ব্যাংকের নাম আবশ্যক।',
                'bank_id.exists'               => 'অনুগ্রহ করে তালিকা থেকে একটি বৈধ ব্যাংক নির্বাচন করুন।',
                'branch.required'              => 'শাখা আবশ্যক।',
            ]);

            $data = [
                'payment_method'      => 'bank',
                'account_holder_name' => $request->account_holder_name,
                'account_number'      => $request->account_number,
                'bank_id'             => $request->bank_id,
                'branch'              => $request->branch,
            ];
        } else {
            $request->validate([
                'mobile_number' => 'required|string|min:11|max:15',
            ], [
                'mobile_number.required' => 'মোবাইল ব্যাংকিং নম্বর আবশ্যক।',
                'mobile_number.min'      => 'সঠিক নম্বর প্রদান করুন।',
            ]);

            $data = [
                'payment_method'      => $request->payment_method,
                'account_holder_name' => null,
                'account_number'      => $request->mobile_number,
                'bank_id'             => null,
                'branch'              => null,
            ];
        }

        session(['loan_application' => $data]);

        return redirect()->route('loan.step2');
    }

    public function step2()
    {
        if (!session()->has('loan_application')) {
            return redirect()->route('loan.step1');
        }

        $sessionData = session('loan_application');
        return view('loan.step2', compact('sessionData'));
    }

    public function postStep2(Request $request)
    {
        if (!session()->has('loan_application')) {
            return redirect()->route('loan.step1');
        }

        $request->validate([
            'amount' => 'required|numeric|min:5000|max:5000000',
            'tenure' => 'required|numeric|in:12,18,24,36,48',
        ], [
            'amount.required' => 'ঋণের পরিমাণ আবশ্যক।',
            'amount.min'      => 'ঋণের পরিমাণ সর্বনিম্ন ৫,০০০ টাকা হতে হবে।',
            'tenure.required' => 'ঋণের মেয়াদ আবশ্যক।',
        ]);

        $amount = (double) $request->amount;
        $tenure = (int) $request->tenure;
        $interestRate = 2.4; // flat rate barshik

        $interestAmount = $amount * ($interestRate / 100) * ($tenure / 12);
        $totalPayable = $amount + $interestAmount;
        $monthlyInstallment = $totalPayable / $tenure;

        $data = session('loan_application');
        $data['amount']              = $amount;
        $data['tenure']              = $tenure;
        $data['interest_rate']       = $interestRate;
        $data['interest_amount']     = $interestAmount;
        $data['total_payable']       = $totalPayable;
        $data['monthly_installment'] = $monthlyInstallment;

        session(['loan_application' => $data]);

        return redirect()->route('loan.step3');
    }

    public function step3()
    {
        if (!session()->has('loan_application') || !isset(session('loan_application')['amount'])) {
            return redirect()->route('loan.step1');
        }

        $loan = session('loan_application');
        return view('loan.info', compact('loan'));
    }

    public function submit(Request $request)
    {
        if (!session()->has('loan_application') || !isset(session('loan_application')['amount'])) {
            return redirect()->route('loan.step1');
        }

        $request->validate([
            'agree' => 'required|accepted',
        ], [
            'agree.required' => 'আপনাকে অবশ্যই নিয়ম ও শর্তাবলী মেনে নিতে হবে।',
            'agree.accepted' => 'আপনাকে অবশ্যই নিয়ম ও শর্তাবলী মেনে নিতে হবে।',
        ]);

        $data = session('loan_application');
        
        $loan = Loan::create([
            'user_id'             => Auth::id(),
            'payment_method'      => $data['payment_method'],
            'account_holder_name' => $data['account_holder_name'],
            'account_number'      => $data['account_number'],
            'bank_id'             => $data['bank_id'] ?? null,
            'branch'              => $data['branch'],
            'amount'              => $data['amount'],
            'tenure'              => $data['tenure'],
            'interest_rate'       => $data['interest_rate'],
            'interest_amount'     => $data['interest_amount'],
            'total_payable'       => $data['total_payable'],
            'monthly_installment' => $data['monthly_installment'],
            'status'              => 'pending',
        ]);

        session()->forget('loan_application');

        return redirect()->route('loan.success')->with('loan_id', $loan->id);
    }

    public function success()
    {
        $loanId = session('loan_id');
        
        // Handle potential stale session mismatch gracefully
        if ($loanId) {
            $loan = Loan::find($loanId);
            if (!$loan || $loan->user_id !== Auth::id()) {
                $loanId = null;
            }
        }

        if (!$loanId) {
            $latestLoan = Loan::where('user_id', Auth::id())->latest()->first();
            if ($latestLoan) {
                $loan = $latestLoan;
            } else {
                return redirect()->route('customer.dashboard');
            }
        } else {
            $loan = Loan::findOrFail($loanId);
        }

        return view('loan.success', compact('loan'));
    }

    /**
     * Show customer-side loan details (payment guide, administrative message, and screenshot upload)
     */
    public function details($id)
    {
        $loan = Loan::findOrFail($id);
        if ($loan->user_id !== Auth::id()) {
            abort(403);
        }
        return view('loan.details', compact('loan'));
    }

    /**
     * Handle payment screenshot upload by customer
     */
    public function uploadScreenshot(Request $request, $id)
    {
        $request->validate([
            'screenshot' => 'required|image|max:10240', // Max 10MB
        ], [
            'screenshot.required' => 'পেমেন্টের স্ক্রিনশট ফাইলটি নির্বাচন করুন।',
            'screenshot.image' => 'আপলোড করা ফাইলটি অবশ্যই একটি ছবি হতে হবে।',
            'screenshot.max' => 'ফাইলের আকার ১০ মেগাবাইটের কম হতে হবে।',
        ]);

        $loan = Loan::findOrFail($id);
        if ($loan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = time() . '_receipt_' . $loan->id . '.' . $file->getClientOriginalExtension();
            
            $uploadPath = public_path('uploads/information');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $filename);
            
            $loan->screenshot = 'uploads/information/' . $filename;
            $loan->save();

            return redirect()->back()->with('success', 'পেমেন্টের স্ক্রিনশট সফলভাবে আপলোড করা হয়েছে।');
        }

        return redirect()->back()->with('error', 'ফাইল আপলোড করতে ব্যর্থ হয়েছে।');
    }
}
