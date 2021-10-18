<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Social as Request;

class Social extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("panel::settings.social", [
            "settings" => get_settings("site"),
        ]);
    }

    /**
     * Update social settings
     *
     * @return Response
     */
    public function update(Request $request)
    {
        // get settings model
        $settings = get_settings("site", true);

        $data = json_decode($settings->value);

        $data->facebook_url = $request->input("facebook_url");
        $data->instagram_url = $request->input("instagram_url");
        $data->twitter_url = $request->input("twitter_url");
        $data->youtube_url = $request->input("youtube_url");
        $data->linkedin_url = $request->input("linkedin_url");
        $data->tiktok_url = $request->input("tiktok_url");

        $settings->value = json_encode($data);

        $settings->save();

        return redirect()
            ->route("panel.settings.social")
            ->with("form_success", "Settings saved.");
    }
}
