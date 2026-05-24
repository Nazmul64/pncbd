<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FraudApi;

class FraudApiController extends Controller
{
    public function index()
    {
        $apis = FraudApi::all();
        return view('admin.fraud_api.index', compact('apis'));
    }

    public function update(Request $request, $id)
    {
        $api = FraudApi::findOrFail($id);
        
        $api->update([
            'api_url' => $request->input('api_url'),
            'api_key' => $request->input('api_key'),
        ]);

        return redirect()->back()->with('success', 'Fraud API details updated successfully.');
    }

    public function toggleActive(Request $request, $id)
    {
        // Deactivate all
        FraudApi::query()->update(['is_active' => false]);
        
        // Activate the selected one
        $api = FraudApi::findOrFail($id);
        $api->is_active = true;
        $api->save();

        return redirect()->back()->with('success', ucfirst($api->type) . ' API is now active.');
    }
}
