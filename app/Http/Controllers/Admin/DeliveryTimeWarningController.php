<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTimeWarning;
use Illuminate\Http\Request;

class DeliveryTimeWarningController extends Controller
{
    public function index()
    {
        $deliveryWarning = DeliveryTimeWarning::first();
        return view('admin.delivery_warning.index', compact('deliveryWarning'));
    }

    public function update(Request $request)
    {
        \Log::info('DeliveryTimeWarning update request payload:', $request->all());

        $request->validate([
            'button_text' => 'nullable|string|max:255',
            'warning_text' => 'nullable|string',
        ]);

        $isActive = $request->has('is_active') ? true : false;
        $deliveryWarning = DeliveryTimeWarning::first();

        if ($deliveryWarning) {
            $deliveryWarning->update([
                'button_text' => $request->button_text,
                'warning_text' => $request->warning_text,
                'is_active'    => $isActive,
            ]);
        } else {
            DeliveryTimeWarning::create([
                'button_text' => $request->button_text,
                'warning_text' => $request->warning_text,
                'is_active'    => $isActive,
            ]);
        }

        return redirect()->back()->with('success', 'Delivery Time Warning updated successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $deliveryWarning = DeliveryTimeWarning::first();
        $isActive = $request->input('is_active') == 1 ? true : false;

        if ($deliveryWarning) {
            $deliveryWarning->update([
                'is_active' => $isActive,
            ]);
        } else {
            $deliveryWarning = DeliveryTimeWarning::create([
                'button_text' => 'Delivery within 24-72 hrs.',
                'warning_text' => 'বিঃদ্রঃ- দয়া করে ১০০% শিওর হয়ে অর্ডার করবেন। ছবি এবং বর্ণনার সাথে পণ্যের মিল থাকা সত্ত্বেও আপনি পণ্য গ্রহণ করতে না চাইলে কুরিয়ার চার্জ ১৫০টাকা কুরিয়ার ডেলিভারি ম্যানকে প্রদান করে পণ্য সাথে সাথে রিটার্ন করবেন। পরে কোন কমপ্লেইন/রিটার্ন গ্রহণযোগ্য নয়! অযথা অর্ডার থেকে বিরত থাকুন, কারন আপনার মোবাইল নাম্বার এড্রেস ডিভাইস আইপি নাম্বার দেখা যায়।',
                'is_active' => $isActive,
            ]);
        }

        return response()->json([
            'success' => true,
            'is_active' => $deliveryWarning->is_active,
            'message' => $deliveryWarning->is_active ? 'ডেলিভারি সতর্কতা সফলভাবে অন করা হয়েছে!' : 'ডেলিভারি সতর্কতা সফলভাবে অফ করা হয়েছে!'
        ]);
    }
}
