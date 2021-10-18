<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Auth\Address;
use Illuminate\Support\Facades\Auth;

class Addresses extends Controller
{
    public function index()
    {
        $shipping_addresses = Address::where('user_id', '=', Auth::user()->id)->where('type', '=', 'shipping')->get();
        $billing_addresses = Address::where('user_id', '=', Auth::user()->id)->where('type', '=', 'billing')->get();

        return view('core::auth.addresses', [
            'shipping_addresses' => $shipping_addresses,
            'billing_addresses' => $billing_addresses
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        Address::where('id', '=', $id)->delete();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $address_data = $request->input('address_data');

        $address = Address::where('id', '=', $id)->first();

        $new_address_data = [
            'first_name' => $address_data['first_name'],
            'last_name' => $address_data['last_name'],
            'phone' => $address_data['phone'],
            'city' => $address_data['city'],
            'district' => $address_data['district'],
            'address' => $address_data['address'],
            'address_name' => $address_data['address_name']
        ];

        if (isset($address_data['bill_type'])) {
            $new_address_data = [
                'first_name' => $address_data['first_name'],
                'last_name' => $address_data['last_name'],
                'phone' => $address_data['phone'],
                'city' => $address_data['city'],
                'district' => $address_data['district'],
                'address' => $address_data['address'],
                'address_name' => $address_data['address_name'],
                'bill_type' => $address_data['bill_type'],
            ];

            if ($address_data['bill_type'] == 'company') {
                $new_address_data = [
                    'first_name' => $address_data['first_name'],
                    'last_name' => $address_data['last_name'],
                    'phone' => $address_data['phone'],
                    'city' => $address_data['city'],
                    'district' => $address_data['district'],
                    'address' => $address_data['address'],
                    'address_name' => $address_data['address_name'],
                    'bill_type' => $address_data['bill_type'],
                    'company_name' => $address_data['company_name'],
                    'company_tax_number' => $address_data['company_tax_number'],
                    'company_tax_administration' => $address_data['company_tax_administration'],
                    'e_bill_user' => $address_data['e_bill_user'],
                ];
            }
        }

        $address->details = json_encode($new_address_data);

        $address->save();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function create(Request $request)
    {
        $address_data = $request->input('address_data');

        // create new address for the billing
        if (isset($address_data['bill_type']) && !isset($address_data['create_bill_shipping'])) {
            $billing_address = new Address;
            $billing_address->user_id = Auth::user()->id;
            $billing_address->type = 'billing';

            if ($address_data['bill_type'] == 'company') {
                $billing_address->details = json_encode([
                    'first_name' => $address_data['first_name'],
                    'last_name' => $address_data['last_name'],
                    'phone' => $address_data['phone'],
                    'city' => $address_data['city'],
                    'district' => $address_data['district'],
                    'neighborhood' => $address_data['neighborhood'],
                    'address' => $address_data['address'],
                    'address_name' => $address_data['address_name'],
                    'bill_type' => $address_data['bill_type'],
                    'company_name' => $address_data['company_name'],
                    'company_tax_number' => $address_data['company_tax_number'],
                    'company_tax_administration' => $address_data['company_tax_administration'],
                    'e_bill_user' => $address_data['e_bill_user'],
                ]);
            } else {
                $billing_address->details = json_encode([
                    'first_name' => $address_data['first_name'],
                    'last_name' => $address_data['last_name'],
                    'phone' => $address_data['phone'],
                    'city' => $address_data['city'],
                    'district' => $address_data['district'],
                    'neighborhood' => $address_data['neighborhood'],
                    'address' => $address_data['address'],
                    'address_name' => $address_data['address_name'],
                    'bill_type' => $address_data['bill_type'],
                ]);
            }

            $billing_address->save();
        } else if (isset($address_data['bill_type']) && isset($address_data['create_bill_shipping'])) {
            $billing_address = new Address;
            $billing_address->user_id = Auth::user()->id;
            $billing_address->type = 'billing';

            if ($address_data['bill_type'] == 'company') {
                $billing_address->details = json_encode([
                    'first_name' => $address_data['first_name'],
                    'last_name' => $address_data['last_name'],
                    'phone' => $address_data['phone'],
                    'city' => $address_data['city'],
                    'district' => $address_data['district'],
                    'neighborhood' => $address_data['neighborhood'],
                    'address' => $address_data['address'],
                    'address_name' => $address_data['address_name'],
                    'bill_type' => $address_data['bill_type'],
                    'company_name' => $address_data['company_name'],
                    'company_tax_number' => $address_data['company_tax_number'],
                    'company_tax_administration' => $address_data['company_tax_administration'],
                    'e_bill_user' => $address_data['e_bill_user'],
                ]);
            } else {
                $billing_address->details = json_encode([
                    'first_name' => $address_data['first_name'],
                    'last_name' => $address_data['last_name'],
                    'phone' => $address_data['phone'],
                    'city' => $address_data['city'],
                    'district' => $address_data['district'],
                    'neighborhood' => $address_data['neighborhood'],
                    'address' => $address_data['address'],
                    'address_name' => $address_data['address_name'],
                    'bill_type' => $address_data['bill_type'],
                ]);
            }

            $billing_address->save();

            $address = new Address;

            $new_address_data = [
                'first_name' => $address_data['first_name'],
                'last_name' => $address_data['last_name'],
                'phone' => $address_data['phone'],
                'city' => $address_data['city'],
                'district' => $address_data['district'],
                'neighborhood' => $address_data['neighborhood'],
                'address' => $address_data['address'],
                'address_name' => $address_data['address_name']
            ];

            $address->user_id = Auth::user()->id;
            $address->details = json_encode($new_address_data);
            $address->type = 'shipping';

            $address->save();
        } else {
            $address = new Address;

            $new_address_data = [
                'first_name' => $address_data['first_name'],
                'last_name' => $address_data['last_name'],
                'phone' => $address_data['phone'],
                'city' => $address_data['city'],
                'district' => $address_data['district'],
                'neighborhood' => $address_data['neighborhood'],
                'address' => $address_data['address'],
                'address_name' => $address_data['address_name']
            ];

            $address->user_id = Auth::user()->id;
            $address->details = json_encode($new_address_data);
            $address->type = 'shipping';

            $address->save();
        }

        return response()
            ->json([
                'success' => true
            ]);
    }
}
