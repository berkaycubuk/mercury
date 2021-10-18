<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Setting;

class Shipment extends Controller
{
    public function index()
    {
        return view('panel::settings.shipment.index');
    }

    public function create()
    {
        return view('panel::settings.shipment.create');
    }

    public function edit($id)
    {
        $settings = get_settings('shipment');

        $method = null;

        foreach ($settings as $setting) {
            if ($setting->id == $id) {
                $method = $setting;
                break;
            }
        }

        if ($method == null) {
            return redirect()
                ->route('panel.settings.shipment');
        }

        return view('panel::settings.shipment.edit', compact('method'));
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $all_locations = $request->input('all-locations');
        $locations_json = $request->input('locations-json');
        $price = $request->input('location-price-all');

        $shipmentSettings = Setting::where('key', 'shipment')->first();
        $shipmentMethods = json_decode($shipmentSettings->value);

        $location = null;

        if ($all_locations) {
            $location = [
                'id' => md5($name . date('h:i:s-d.m.Y')),
                'name' => $name,
                'price' => $price
            ];
        } else {
            $location = [
                'id' => md5($name . date('h:i:s-d.m.Y')),
                'name' => $name,
                'locations' => json_decode($locations_json)
            ];
        }

        array_push($shipmentMethods, $location);
        $shipmentSettings->value = json_encode($shipmentMethods);
        $shipmentSettings->save();

        return redirect()
            ->route('panel.settings.shipment');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $all_locations = $request->input('all-locations');
        $locations_json = $request->input('locations-json');
        $price = $request->input('location-price-all');

        $shipmentSettings = Setting::where('key', 'shipment')->first();
        $shipmentMethods = json_decode($shipmentSettings->value);

        $location = null;

        if ($all_locations) {
            $location = [
                'id' => $id,
                'name' => $name,
                'price' => $price
            ];
        } else {
            $location = [
                'id' => $id,
                'name' => $name,
                'locations' => json_decode($locations_json)
            ];
        }

        foreach ($shipmentMethods as $key => $method) {
            if ($method->id == $id) {
                $shipmentMethods[$key] = $location;
                break;
            }
        }

        $shipmentSettings->value = json_encode($shipmentMethods);
        $shipmentSettings->save();

        return redirect()
            ->route('panel.settings.shipment');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $shipmentSettings = Setting::where('key', 'shipment')->first();
        $shipmentMethods = json_decode($shipmentSettings->value);

        foreach ($shipmentMethods as $key => $method) {
            if ($method->id == $id) {
                array_splice($shipmentMethods, $key, 1);
                break;
            }
        }

        $shipmentSettings->value = json_encode($shipmentMethods);
        $shipmentSettings->save();

        return response()
            ->json([
                'success' => true,
                'message' => 'Shipping method successfully deleted'
            ], 200);
    }
}
