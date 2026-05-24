<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AdminUserInformationController extends Controller
{
    /**
     * Display a listing of all submitted user documents/information.
     */
    public function index(Request $request)
    {
        $query = UserInformation::with('user')->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('nid_number', 'like', "%{$search}%")
                  ->orWhere('occupation', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('phone', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $informations = $query->paginate(15);

        return view('admin.user_informations.index', compact('informations'));
    }

    /**
     * Display the specified user's detailed information and uploaded documents.
     */
    public function show($id)
    {
        $information = UserInformation::with('user')->findOrFail($id);
        
        return view('admin.user_informations.show', compact('information'));
    }

    /**
     * Remove the specified user information/documents and clean up storage files.
     */
    public function destroy($id)
    {
        $information = UserInformation::findOrFail($id);

        try {
            // Document files to clean up
            $filesToDelete = [
                $information->selfie,
                $information->nid_front,
                $information->nid_back,
                $information->other_document,
                $information->signature,
            ];

            foreach ($filesToDelete as $filePath) {
                if ($filePath) {
                    $absolutePath = public_path($filePath);
                    if (File::exists($absolutePath)) {
                        File::delete($absolutePath);
                    }
                }
            }

            $information->delete();

            return redirect()->route('admin.documentation.index')
                ->with('success', 'গ্রাহকের ডকুমেন্ট এবং তথ্য সফলভাবে মুছে ফেলা হয়েছে।');

        } catch (\Exception $e) {
            Log::error('AdminUserInformation Destroy Error: ' . $e->getMessage());
            return back()->with('error', 'ডকুমেন্ট মুছতে সমস্যা হয়েছে, আবার চেষ্টা করুন।');
        }
    }
}
