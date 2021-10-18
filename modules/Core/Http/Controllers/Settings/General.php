<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Setting;
use Core\Models\Media;

class General extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $media = Media::all();

        return view("panel::settings.general", [
            "siteSettings" => get_settings("site"),
            "media" => $media
        ]);
    }

    /**
     * Update resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $siteSettings = Setting::where("key", "=", "site")->first();

        $settings = json_decode($siteSettings->value);

        $settings->title = $request->input("title");
        $settings->description = $request->input("description");
        $settings->logo = $request->input("logo");
        $settings->favicon = $request->input("favicon");

        if ($request->input("service-mode")) {
            $settings->service_mode = true;
        } else {
            $settings->service_mode = false;
        }

        $siteSettings->value = json_encode($settings);
        $siteSettings->save();

        return redirect()
            ->route("panel.settings.general")
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.settings", 1),
                ])
            );
    }
}
