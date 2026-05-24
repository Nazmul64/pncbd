<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('admin.profile.index', compact('user'));
        } elseif ($user->isManager()) {
            return view('manager.profile.index', compact('user'));
        } elseif ($user->isEmployee()) {
            return view('emplee.profile.index', compact('user'));
        } elseif ($user->isCustomer()) {
            return view('userdashboard.profile', compact('user'));
        }

        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    /**
     * Update basic profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user->isCustomer()) {
            $request->validate([
                'name'              => 'required|string|max:255',
                'email'             => 'required|email|unique:users,email,' . $user->id,
                'phone'             => 'required|string|max:20',
                'occupation'        => 'required|string|max:255',
                'current_address'   => 'required|string',
                'permanent_address' => 'required|string',
                'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            ], [
                'name.required'              => 'অনুগ্রহ করে পূর্ণ নাম লিখুন।',
                'email.required'             => 'অনুগ্রহ করে ইমেইল লিখুন।',
                'email.email'                => 'সঠিক ইমেইল লিখুন।',
                'email.unique'               => 'এই ইমেইল দিয়ে ইতিমধ্যে অ্যাকাউন্ট আছে।',
                'phone.required'             => 'অনুগ্রহ করে ফোন নম্বর লিখুন।',
                'occupation.required'        => 'অনুগ্রহ করে পেশা লিখুন।',
                'current_address.required'   => 'অনুগ্রহ করে বর্তমান ঠিকানা লিখুন।',
                'permanent_address.required' => 'অনুগ্রহ করে স্থায়ী ঠিকানা লিখুন।',
                'photo.image'                => 'ছবি অবশ্যই একটি ইমেজ ফাইল হতে হবে।',
                'photo.max'                  => 'ছবি সর্বোচ্চ 10MB হতে পারবে।',
            ]);

            // Save basic User details
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            if ($request->hasFile('photo')) {
                $uploadPath = public_path('uploads/imformation');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $image = $request->file('photo');
                $filename = time() . '_selfie_' . $user->id . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $filename);
                
                $selfiePath = 'uploads/imformation/' . $filename;
                $userData['photo'] = $selfiePath;
            }

            $user->update($userData);

            // Update or create UserInformation relation
            $infoData = [
                'full_name'         => $request->name,
                'phone_number'      => $request->phone,
                'occupation'        => $request->occupation,
                'current_address'   => $request->current_address,
                'permanent_address' => $request->permanent_address,
            ];

            if (isset($selfiePath)) {
                $infoData['selfie'] = $selfiePath;
            }

            if ($user->information) {
                $user->information->update($infoData);
            } else {
                $user->information()->create($infoData);
            }

            return redirect()->back()->with('success', 'আপনার প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
        }
        
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'address' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && File::exists(public_path('uploads/avator/' . $user->photo))) {
                File::delete(public_path('uploads/avator/' . $user->photo));
            }

            $image = $request->file('photo');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/avator'), $name);
            $data['photo'] = $name;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে।');
    }
}
