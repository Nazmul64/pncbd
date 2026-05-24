<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    /**
     * Display a listing of the banks.
     */
    public function index()
    {
        $banks = Bank::latest()->get();
        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Store a newly created bank in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name',
        ], [
            'name.required' => 'ব্যাংকের নাম আবশ্যক।',
            'name.unique' => 'এই ব্যাংকটি ইতিমধ্যে যুক্ত করা হয়েছে।',
        ]);

        Bank::create([
            'name' => $request->name,
            'is_active' => true,
        ]);

        return redirect()->route('admin.banks.index')
            ->with('success', 'ব্যাংক সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Update the specified bank in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name,' . $bank->id,
        ], [
            'name.required' => 'ব্যাংকের নাম আবশ্যক।',
            'name.unique' => 'এই ব্যাংকটি ইতিমধ্যে যুক্ত করা হয়েছে।',
        ]);

        $bank->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.banks.index')
            ->with('success', 'ব্যাংকের নাম সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified bank from storage.
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('admin.banks.index')
            ->with('success', 'ব্যাংক সফলভাবে মুছে ফেলা হয়েছে।');
    }

    /**
     * Toggle the active status of the bank.
     */
    public function toggleStatus(Bank $bank)
    {
        $bank->update([
            'is_active' => !$bank->is_active
        ]);

        return redirect()->route('admin.banks.index')
            ->with('success', 'ব্যাংকের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
    }
}
