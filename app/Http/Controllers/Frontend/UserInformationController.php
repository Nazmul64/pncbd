<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    /**
     * Show the information form (after registration)
     */
    public function create()
    {
        $user = auth()->user();

        // Already submitted? Go to dashboard
        if (UserInformation::where('user_id', $user->id)->exists()) {
            return redirect()->route('customer.dashboard');
        }

        return view('userdashboard.information', compact('user'));
    }

    /**
     * Store the submitted information and documents
     * Uploads go to: public/uploads/information/
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Prevent duplicate submission
        if (UserInformation::where('user_id', $user->id)->exists()) {
            return redirect()->route('customer.dashboard')
                ->with('info', 'আপনার তথ্য ইতিমধ্যে সংরক্ষিত আছে।');
        }

        $request->validate([
            'full_name'         => 'required|string|max:255',
            'nid_number'        => 'required|string|max:50',
            'phone_number'      => 'required|string|max:20',
            'occupation'        => 'required|string|max:255',
            'current_address'   => 'required|string',
            'permanent_address' => 'required|string',
            'loan_reason'       => 'nullable|string',
            'selfie'            => 'required|image|max:10240',
            'nid_front'         => 'required|image|max:10240',
            'nid_back'          => 'required|image|max:10240',
            'other_document'    => 'nullable|file|max:10240',
            'signature'         => 'required|string',
            'nominee_name'      => 'required|string|max:255',
            'nominee_relation'  => 'required|string|max:255',
            'nominee_phone'     => 'required|string|max:20',
        ], [
            'full_name.required'         => 'অনুগ্রহ করে পূর্ণ নাম লিখুন।',
            'nid_number.required'        => 'অনুগ্রহ করে NID নম্বর লিখুন।',
            'phone_number.required'      => 'অনুগ্রহ করে ফোন নম্বর লিখুন।',
            'occupation.required'        => 'অনুগ্রহ করে পেশা লিখুন।',
            'current_address.required'   => 'অনুগ্রহ করে বর্তমান ঠিকানা লিখুন।',
            'permanent_address.required' => 'অনুগ্রহ করে স্থায়ী ঠিকানা লিখুন।',
            'selfie.required'            => 'অনুগ্রহ করে সেলফি আপলোড করুন।',
            'selfie.image'               => 'সেলফি অবশ্যই একটি ছবি হতে হবে।',
            'selfie.max'                 => 'সেলফি সর্বোচ্চ 10MB হতে পারবে।',
            'nid_front.required'         => 'অনুগ্রহ করে NID এর সামনের অংশ আপলোড করুন।',
            'nid_front.image'            => 'NID সামনের অংশ অবশ্যই একটি ছবি হতে হবে।',
            'nid_front.max'              => 'NID সামনের অংশ সর্বোচ্চ 10MB হতে পারবে।',
            'nid_back.required'          => 'অনুগ্রহ করে NID এর পিছনের অংশ আপলোড করুন।',
            'nid_back.image'             => 'NID পিছনের অংশ অবশ্যই একটি ছবি হতে হবে।',
            'nid_back.max'               => 'NID পিছনের অংশ সর্বোচ্চ 10MB হতে পারবে।',
            'other_document.max'         => 'ডকুমেন্ট সর্বোচ্চ 10MB হতে পারবে।',
            'signature.required'         => 'অনুগ্রহ করে আপনার স্বাক্ষর দিন।',
            'nominee_name.required'      => 'অনুগ্রহ করে নমিনির নাম লিখুন।',
            'nominee_relation.required'  => 'অনুগ্রহ করে সম্পর্ক লিখুন।',
            'nominee_phone.required'     => 'অনুগ্রহ করে নমিনির ফোন নম্বর লিখুন।',
        ]);

        // Ensure upload directory exists
        $uploadPath = public_path('uploads/information');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $data = [
            'user_id'           => $user->id,
            'full_name'         => $request->full_name,
            'nid_number'        => $request->nid_number,
            'phone_number'      => $request->phone_number,
            'occupation'        => $request->occupation,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'loan_reason'       => $request->loan_reason,
            'nominee_name'      => $request->nominee_name,
            'nominee_relation'  => $request->nominee_relation,
            'nominee_phone'     => $request->nominee_phone,
        ];

        // ── Upload Selfie ──
        if ($request->hasFile('selfie')) {
            $file     = $request->file('selfie');
            $filename = time() . '_selfie_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['selfie'] = 'uploads/information/' . $filename;
        }

        // ── Upload NID Front ──
        if ($request->hasFile('nid_front')) {
            $file     = $request->file('nid_front');
            $filename = time() . '_nid_front_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['nid_front'] = 'uploads/information/' . $filename;
        }

        // ── Upload NID Back ──
        if ($request->hasFile('nid_back')) {
            $file     = $request->file('nid_back');
            $filename = time() . '_nid_back_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['nid_back'] = 'uploads/information/' . $filename;
        }

        // ── Upload Other Document (optional) ──
        if ($request->hasFile('other_document')) {
            $file     = $request->file('other_document');
            $filename = time() . '_other_doc_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['other_document'] = 'uploads/information/' . $filename;
        }

        // ── Save Signature (base64 → image file) ──
        if ($request->filled('signature')) {
            $signatureData = $request->signature;
            if (preg_match('/^data:image\/(\w+);base64,/', $signatureData, $type)) {
                $ext           = strtolower($type[1]);
                $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
                $signatureData = base64_decode($signatureData);
                $sigFilename   = time() . '_signature_' . $user->id . '.' . $ext;
                file_put_contents($uploadPath . '/' . $sigFilename, $signatureData);
                $data['signature'] = 'uploads/information/' . $sigFilename;
            }
        }

        try {
            UserInformation::create($data);

            return redirect()->route('customer.dashboard')
                ->with('success', 'আপনার তথ্য সফলভাবে সংরক্ষণ করা হয়েছে।');

        } catch (\Exception $e) {
            Log::error('UserInformation Store Error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'তথ্য সংরক্ষণ ব্যর্থ হয়েছে, আবার চেষ্টা করুন।'])
                ->withInput();
        }
    }
}
