<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Setting;
use Core\Models\Media;

class Frontpage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $media = Media::all();

        return view("panel::settings.frontpage", [
            "frontpage" => get_settings("frontpage"),
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
        $frontpage = Setting::where("key", "=", "frontpage")->first();

        $settings = json_decode($frontpage->value);

        // Values to change
        $settings->main_slider = json_decode($request->input('main-slider'));

        $settings->what_we_do->title = $request->input('what-we-do-title');
        $settings->what_we_do->description = $request->input('what-we-do-description');
        $settings->what_we_do->images = [
            $request->input('what-we-do-image-1'),
            $request->input('what-we-do-image-2'),
            $request->input('what-we-do-image-3'),
            $request->input('what-we-do-image-4'),
        ];

        $settings->online_order_cta->title = $request->input("online-order-cta-title");
        $settings->online_order_cta->description = $request->input("online-order-cta-description");
        $settings->online_order_cta->button->text = $request->input("online-order-cta-button-text");
        $settings->online_order_cta->button->url  = $request->input("online-order-cta-button-url");
        $settings->online_order_cta->images = [
            $request->input('online-order-image-1'),
            $request->input('online-order-image-2'),
            $request->input('online-order-image-3'),
            $request->input('online-order-image-4'),
        ];

        $settings->the_story->title = $request->input("the-story-title");
        $settings->the_story->description = $request->input("the-story-description");
        $settings->the_story->button->text = $request->input("the-story-button-text");
        $settings->the_story->button->url  = $request->input("the-story-button-url");
        $settings->the_story->image  = $request->input("the-story-image");

        $settings->product_showcase->title = $request->input("product-showcase-title");
        $settings->product_showcase->description = $request->input("product-showcase-description");
        $settings->product_showcase->button->text = $request->input("product-showcase-button-text");
        $settings->product_showcase->button->url  = $request->input("product-showcase-button-url");

        $frontpage->value = json_encode($settings);
        $frontpage->save();

        return redirect()
            ->route("panel.settings.frontpage")
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans("general.settings"),
                ])
            );
    }
}
