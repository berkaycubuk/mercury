<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Setting;

class Integrations extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $settings = get_settings("integration");
        return view('panel::settings.integrations', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = get_settings("integration", true);  

        $googleAnalytics = $request->input('google-analytics');

        $value = [];

        if ($googleAnalytics != null) {
            $value['google_analytics'] = $googleAnalytics;
        } else {
            $value['google_analytics'] = '';
        }

        $settings->value = json_encode($value);
        $settings->save();

        return redirect()->route("panel.settings.integrations");
    }
}
