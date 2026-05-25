<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoanContractStampController extends Controller
{
    /**
     * Show the stamp management page with a list of all stamps.
     */
    public function index()
    {
        // Get all files in the public/uploads/information directory directly
        $dirPath = public_path('uploads/information');
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $files = array_diff(scandir($dirPath), ['.', '..']);
        
        $stamps = collect($files)->map(function ($filename) {
            return [
                'filename' => $filename,
                'url' => asset('uploads/information/' . $filename),
            ];
        })->values();

        return view('admin.loan_contract_stamp', compact('stamps'));
    }

    /**
     * Upload a brand‑new stamp image.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'stamp' => 'required|image|max:2048', // 2 MB limit
        ]);

        $file = $request->file('stamp');
        $originalName = $file->getClientOriginalName();
        
        $dirPath = public_path('uploads/information');
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        // Move to public/uploads/information
        $file->move($dirPath, $originalName);

        return back()->with('success', 'Stamp uploaded successfully.');
    }

    /**
     * Replace an existing stamp with a new file.
     */
    public function replace(Request $request, $filename)
    {
        $request->validate([
            'stamp' => 'required|image|max:2048',
        ]);

        $file = $request->file('stamp');
        $dirPath = public_path('uploads/information');

        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        // Overwrite the file in public/uploads/information
        $file->move($dirPath, $filename);

        return back()->with('success', "Stamp '{$filename}' replaced successfully.");
    }

    /**
     * Delete a specific stamp.
     */
    public function delete(Request $request, $filename)
    {
        $filePath = public_path('uploads/information/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return back()->with('success', "Stamp '{$filename}' deleted successfully.");
    }
}
?>
