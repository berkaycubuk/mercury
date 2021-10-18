<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Setting;

class Menu extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("panel::settings.menu");
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
        $menuSettings = Setting::where("key", "=", "menu")->first();

        $settings = json_decode($menuSettings->value);

        $settings->special = json_decode($request->input('special-menu'));
        $settings->header = json_decode($request->input('header-menu'));
        $settings->footer = json_decode($request->input('footer-menu'));

        $menuSettings->value = json_encode($settings);

        $menuSettings->save();

        return redirect()
            ->route("panel.settings.menu")
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.settings", 1),
                ])
            );
    }
}
