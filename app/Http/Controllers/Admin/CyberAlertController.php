<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CyberAlert;

class CyberAlertController extends Controller
{
    public function index()
    {
        $alerts = CyberAlert::latest()->get();
        return view('admin.cyber_alerts.index', compact('alerts'));
    }

    public function destroy($id)
    {
        $alert = CyberAlert::findOrFail($id);
        $alert->delete();
        return redirect()->back()->with('success', 'Cyber alert has been deleted successfully.');
    }
}
