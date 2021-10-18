<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Setting\Contact as Request;
use Core\Models\Setting;

class Contact extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("panel::settings.contact", [
            "siteSettings" => get_settings("site"),
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

        $settings->email = $request->input("email");
        $settings->phone = $request->input("phone");

        $siteSettings->value = json_encode($settings);
        $siteSettings->save();

        return redirect()
            ->route("panel.settings.contact")
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans("general.settings"),
                ])
            );
    }
}
