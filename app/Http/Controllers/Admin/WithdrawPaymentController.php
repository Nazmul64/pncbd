<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawPaymentNumber;
use Illuminate\Http\Request;

class WithdrawPaymentController extends Controller
{
    /**
     * GET /admin/withdraw-payment-setup
     */
    public function index()
    {
        $numbers = WithdrawPaymentNumber::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.withdraw_payment.index', compact('numbers'));
    }

    /**
     * POST /admin/withdraw-payment-setup/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_name'     => 'required|string|max:100',
            'payment_method' => 'required|string|in:bkash,nagad,rocket,bank',
            'account_number' => 'required|string|max:30',
            'account_holder' => 'nullable|string|max:100',
            'pin'            => 'nullable|string|max:10',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        WithdrawPaymentNumber::create([
            'group_name'     => $request->group_name,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'pin'            => $request->pin,
            'is_active'      => $request->has('is_active'),
            'sort_order'     => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'পেমেন্ট নম্বর সফলভাবে যোগ করা হয়েছে।');
    }

    /**
     * POST /admin/withdraw-payment-setup/{id}/update
     */
    public function update(Request $request, $id)
    {
        $number = WithdrawPaymentNumber::findOrFail($id);

        $request->validate([
            'group_name'     => 'required|string|max:100',
            'payment_method' => 'required|string|in:bkash,nagad,rocket,bank',
            'account_number' => 'required|string|max:30',
            'account_holder' => 'nullable|string|max:100',
            'pin'            => 'nullable|string|max:10',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        $number->update([
            'group_name'     => $request->group_name,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'pin'            => $request->pin,
            'is_active'      => $request->has('is_active'),
            'sort_order'     => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'পেমেন্ট নম্বর সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * POST /admin/withdraw-payment-setup/{id}/toggle
     */
    public function toggle($id)
    {
        $number = WithdrawPaymentNumber::findOrFail($id);
        $number->update(['is_active' => !$number->is_active]);
        return back()->with('success', 'স্ট্যাটাস পরিবর্তন হয়েছে।');
    }

    /**
     * DELETE /admin/withdraw-payment-setup/{id}
     */
    public function destroy($id)
    {
        WithdrawPaymentNumber::findOrFail($id)->delete();
        return back()->with('success', 'পেমেন্ট নম্বর মুছে ফেলা হয়েছে।');
    }
}
