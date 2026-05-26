<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateStampController extends Controller
{
    /**
     * Show the certificate stamp settings page.
     */
    public function index()
    {
        $dirPath = public_path('uploads/onomodon');
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $seals = [
            'ubs_seal' => [
                'title' => 'Pncbd Seal (Circular)',
                'filename' => 'ubs_seal.png',
                'url' => file_exists($dirPath . '/ubs_seal.png') ? asset('uploads/onomodon/ubs_seal.png') : null,
            ],
            'govt_seal' => [
                'title' => 'Bangladesh Govt Seal (Circular)',
                'filename' => 'govt_seal.png',
                'url' => file_exists($dirPath . '/govt_seal.png') ? asset('uploads/onomodon/govt_seal.png') : null,
            ],
            'legal_seal' => [
                'title' => 'Legal/Leaf Seal (Circular)',
                'filename' => 'legal_seal.png',
                'url' => file_exists($dirPath . '/legal_seal.png') ? asset('uploads/onomodon/legal_seal.png') : null,
            ],
            'approved_seal' => [
                'title' => 'Approved Green Stamp (Watermark/Seal)',
                'filename' => 'approved_seal.png',
                'url' => file_exists($dirPath . '/approved_seal.png') ? asset('uploads/onomodon/approved_seal.png') : null,
            ],
        ];

        $gs = \App\Models\Generalsetting::getSettings();

        return view('admin.certificate_stamp', compact('seals', 'gs'));
    }

    /**
     * Upload or replace a specific certificate stamp.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'seal_type' => 'required|in:ubs_seal,govt_seal,legal_seal,approved_seal',
            'seal_file' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        $sealType = $request->input('seal_type');
        $file = $request->file('seal_file');

        $dirPath = public_path('uploads/onomodon');
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        // Save with fixed names as PNG for transparency support
        $filename = $sealType . '.png';

        // Delete old one if exists
        if (file_exists($dirPath . '/' . $filename)) {
            @unlink($dirPath . '/' . $filename);
        }

        $file->move($dirPath, $filename);

        return back()->with('success', 'Seal uploaded successfully.');
    }

    /**
     * Delete a specific certificate stamp.
     */
    public function delete($sealType)
    {
        if (!in_array($sealType, ['ubs_seal', 'govt_seal', 'legal_seal', 'approved_seal'])) {
            return back()->with('error', 'Invalid seal type.');
        }

        $filePath = public_path('uploads/onomodon/' . $sealType . '.png');
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        return back()->with('success', 'Seal deleted successfully.');
    }

    /**
     * Upload dynamic information assets (signature/seal) stored in the database.
     */
    public function uploadInfoAssets(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|in:cert_signature,approved_seal',
            'asset_file' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        $assetType = $request->input('asset_type');
        $file = $request->file('asset_file');

        $dirPath = public_path('uploads/information');
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        // Generate unique filename to bypass cache issues
        $filename = $assetType . '_' . time() . '.' . $file->getClientOriginalExtension();

        $gs = \App\Models\Generalsetting::getSettings();
        $oldPath = $gs->$assetType;

        if ($oldPath && file_exists(public_path($oldPath))) {
            @unlink(public_path($oldPath));
        }

        $file->move($dirPath, $filename);

        $gs->$assetType = 'uploads/information/' . $filename;
        $gs->save();

        return back()->with('success', 'Asset uploaded successfully.');
    }

    /**
     * Delete dynamic information assets and reset to default.
     */
    public function deleteInfoAsset($type)
    {
        if (!in_array($type, ['cert_signature', 'approved_seal'])) {
            return back()->with('error', 'Invalid asset type.');
        }

        $gs = \App\Models\Generalsetting::getSettings();
        $oldPath = $gs->$type;

        if ($oldPath && file_exists(public_path($oldPath))) {
            @unlink(public_path($oldPath));
        }

        $gs->$type = null;
        $gs->save();

        return back()->with('success', 'Asset deleted successfully.');
    }
}
?>
