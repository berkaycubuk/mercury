<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Core\Models\Location\City;
use Core\Models\Location\District;
use Core\Models\Location\Neighborhood;
use JsonMachine\JsonMachine;

class LocationsSeeder extends Seeder
{
    public function run()
    {
        // Locations
        $locations = JsonMachine::fromFile(asset('assets/etc/locations.json'));

        foreach($locations as $city) {
            $new_city = new City;
            $new_city->name = $city['name'];
            $new_city->save();

            foreach($city['districts'] as $district) {
                $new_district = new District;
                $new_district->city_id = $new_city->id;
                $new_district->name = $district['name'];
                $new_district->save();

               foreach($district['neighborhoods'] as $neighborhood) {
                    $new_neighborhood = new Neighborhood;
                    $new_neighborhood->district_id = $new_district->id;
                    $new_neighborhood->name = $neighborhood;
                    $new_neighborhood->save();
                }
            }
        }
    }
}
