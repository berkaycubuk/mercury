<?php

namespace Core\Http\Controllers\Settings\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Media;
use Core\Models\Setting;
use Illuminate\Support\Str;

class Branches extends Controller
{
    public function createPage()
    {
        $media = Media::all();

        return view('panel::settings.contact.branches.create', [
            'media' => $media
        ]);
    }

    public function delete($id)
    {
        $branch_settings = Setting::where('key', 'branches')->first();
        $branches = json_decode($branch_settings->value);

        foreach ($branches as $key => $branch) {
            if ($branch->id == $id) {
                array_splice($branches, $key, 1);
            }
        }

        $branch_settings->value = json_encode($branches);
        $branch_settings->save();

        return redirect()->route('panel.settings.contact');
    }

    public function create(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $image = $request->input('image');
        $embed_url = $request->input('embed-url');
        $map_url = $request->input('map-url');

        $branch_settings = Setting::where('key', 'branches')->first();
        $branches = json_decode($branch_settings->value);

        $new_branch = [
            'id' => md5($name . date('d.m.Y:h:i:s')),
            'slug' => Str::slug($name, '-'),
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'image' => $image,
            'embed_url' => $embed_url,
            'map_url' => $map_url
        ];

        array_push($branches, $new_branch);
        $branch_settings->value = json_encode($branches);

        $branch_settings->save();

        return redirect()
            ->route('panel.settings.contact')
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans("general.settings"),
                ])
            );
    }

    public function editPage($id)
    {
        $media = Media::all();

        $branches = get_settings('branches');

        $branch = null;

        foreach($branches as $temp) {
            if ($temp->id == $id) {
                $branch = $temp;
            }
        }

        return view('panel::settings.contact.branches.edit', [
            'media' => $media,
            'branch' => $branch
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $image = $request->input('image');
        $embed_url = $request->input('embed-url');
        $map_url = $request->input('map-url');

        $branch_settings = Setting::where('key', 'branches')->first();
        $branches = json_decode($branch_settings->value);

        foreach ($branches as $key => $temp) {
            if ($temp->id == $id) {
                $branches[$key]->name = $name;
                $branches[$key]->address = $address;
                $branches[$key]->phone = $phone;
                $branches[$key]->image = $image;
                $branches[$key]->embed_url = $embed_url;
                $branches[$key]->map_url = $map_url;
            }
        }

        $branch_settings->value = json_encode($branches);

        $branch_settings->save();

        return redirect()
            ->route('panel.settings.contact.branches.edit-page', ['id' => $id])
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans("general.settings"),
                ])
            );
    }
}
