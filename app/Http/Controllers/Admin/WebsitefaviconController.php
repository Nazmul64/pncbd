<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Websitefavicon;
use Illuminate\Http\Request;

class WebsitefaviconController extends Controller
{
    /* ──────────────────────────────────────────
     *  GET  admin/websitefavicon
     * ────────────────────────────────────────── */
    public function index()
    {
        $setting = Websitefavicon::getSettings();
        return view('admin.websitefavicon.index', compact('setting'));
    }

    /* ──────────────────────────────────────────
     *  POST  admin/websitefavicon/upload-logo
     * ────────────────────────────────────────── */
    public function uploadLogo(Request $request)
    {
        // Validate the incoming file: must be an image, allowed extensions, and max 5MB (5120KB)
        $request->validate([
            'logo' => [
                'required',
                'file',
                'image',
                'max:5120', // size in kilobytes (5 MB)
                function ($attribute, $value, $fail) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico'];
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (!in_array($ext, $allowed)) {
                        $fail('Only jpg, jpeg, png, gif, svg, webp, ico files are allowed (Max 5 MB).');
                    }
                },
            ],
        ]);

        $setting = Websitefavicon::getSettings();

        // Delete old logo if it exists
        if ($setting->favicon_logo) {
            $oldPath = public_path($setting->favicon_logo);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/websitefavicon');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Store the new file
        $file = $request->file('logo');
        $filename = time() . '_favicon.' . strtolower($file->getClientOriginalExtension());
        $file->move($uploadDir, $filename);

        // Save path in the database
        $setting->favicon_logo = 'uploads/websitefavicon/' . $filename;
        $setting->save();

        return back()->with('success', 'Logo uploaded and saved successfully!');
    }

    /* ──────────────────────────────────────────
     *  POST  admin/websitefavicon/delete-logo
     * ────────────────────────────────────────── */
    public function deleteLogo(Request $request)
    {
        $setting = Websitefavicon::getSettings();

        if ($setting->favicon_logo) {
            $path = public_path($setting->favicon_logo);
            if (file_exists($path)) {
                @unlink($path);
            }
            $setting->favicon_logo = null;
            $setting->save();
        }

        return back()->with('success', 'Logo removed successfully.');
    }

    // Resource stubs — সব admin.websitefavicon.index এ redirect করে
    public function create()                      { return redirect()->route('admin.websitefavicon.index'); }
    public function store(Request $request)       { return redirect()->route('admin.websitefavicon.index'); }
    public function show($id)                     { return redirect()->route('admin.websitefavicon.index'); }
    public function edit($id)                     { return redirect()->route('admin.websitefavicon.index'); }
    public function update(Request $request, $id) { return redirect()->route('admin.websitefavicon.index'); }
    public function destroy($id)                  { return redirect()->route('admin.websitefavicon.index'); }
}
