<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Settings\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings dashboard.
     */
    public function index()
    {
        // Pluck all settings into a simple key-value array for the view
        $settings = Setting::pluck('value', 'key')->toArray();
        
        return view('settings::index', compact('settings'));
    }

    /**
     * Update the settings in storage.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'favicon']);

        // Handle File Uploads
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            $data['site_logo'] = $path;
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            $data['favicon'] = $path;
        }

        // Loop and Update/Create key-value pairs
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            
            // Clear cache for this specific setting so the helper picks up the new value
            Cache::forget('setting_' . $key);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
