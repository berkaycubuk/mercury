<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use Core\Models\Location\City;
use Core\Models\Location\District;

class Locations extends Controller
{
    public function cities(Request $request)
    {
        $cities = City::orderBy('name', 'ASC')->get();

        return response()
            ->json([
                'data' => $cities,
                'success' => true
            ], 200);
    }

    public function districts(Request $request)
    {
        $districts = City::where('id', $request->city_id)->first()->districts;

        return response()
            ->json([
                'data' => $districts,
                'success' => true
            ], 200);
    }

    public function neighborhoods(Request $request)
    {
        $neighborhoods = District::where('id', $request->district_id)->first()->neighborhoods;

        return response()
            ->json([
                'data' => $neighborhoods,
                'success' => true
            ], 200);
    }

    public function shipmentChoices(Request $request)
    {
        $shipmentLocations = get_settings('shipment');

        $city = $request->input('city');
        $district = $request->input('district');
        $neighborhood = $request->input('neighborhood');

        $choices = [];

        foreach ($shipmentLocations as $location) {
            if (isset($location->locations)) {
                $temp = null;
                foreach ($location->locations as $locationData) {
                    if ($locationData->city->id == $city && $locationData->district->id == $district) {
                        if (empty($locationData->neighborhood)) {
                            $temp = [
                                'id' => $location->id,
                                'name' => $location->name,
                                'price' => $locationData->price
                            ];
                        } else {
                            foreach ($locationData->neighborhood as $data) {
                                if ($data->id == $neighborhood) {
                                    $temp = [
                                        'id' => $location->id,
                                        'name' => $location->name,
                                        'price' => $locationData->price
                                    ];
                                }
                            }
                        }
                    }
                }

                if ($temp != null) {
                    array_push($choices, $temp);
                }
            } else {
                array_push($choices, $location);
            }
        }

        if (empty($choices)) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'No shipping method found'
                ], 400);
        }

        return response()
            ->json([
                'success' => true,
                'choices' => $choices
            ], 200);
    }
}
