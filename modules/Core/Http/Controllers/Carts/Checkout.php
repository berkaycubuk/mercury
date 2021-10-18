<?php

namespace Core\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Core\Models\Auth\Address;
use Core\Models\Order;
use Core\Models\Page;
use Illuminate\Validation\Rule;

class Checkout extends Controller
{
    public function index(Request $request)
    {
        $emptyShippingAddress = (object) [
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'city' => (object) [
                'id' => '',
                'name' => '',
            ],
            'district' => (object) [
                'id' => '',
                'name' => '',
            ],
            'neighborhood' => (object) [
                'id' => '',
                'name' => '',
            ],
            'address' => '',
        ];

        $emptyBillingAddress = (object) [
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'email' => '',
            'company_name' => '',
            'tax_number' => '',
            'tax_administration' => '',
            'bill_type' => '',
            'city' => (object) [
                'id' => '',
                'name' => '',
            ],
            'district' => (object) [
                'id' => '',
                'name' => '',
            ],
            'neighborhood' => (object) [
                'id' => '',
                'name' => '',
            ],
            'address' => '',
        ];

        if (Auth::check()) {
            $shipping_addresses = Address::where('user_id', '=', Auth::user()->id)
                ->where('type', '=', 'shipping')->get();

            $billing_addresses = Address::where('user_id', '=', Auth::user()->id)
                ->where('type', '=', 'billing')->get();

            $shipmentLocations = get_settings('shipment');

            if (!count($shipping_addresses) || !count($billing_addresses)) {
                return view('core::checkout.index', [
                    'shipping_address' => $emptyShippingAddress,
                    'billing_address' => $emptyBillingAddress,
                    'cart' => init_cart(),
                    'shipping_choices' => []
                ]);
            }

            $city = $shipping_addresses[0]->city->id;
            $district = $shipping_addresses[0]->district->id;
            $neighborhood = $shipping_addresses[0]->neighborhood->id;

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
                                    'price' => $locationData->price,
                                ];
                            } else {
                                foreach ($locationData->neighborhood as $data) {
                                    if ($data->id == $neighborhood) {
                                        $temp = [
                                            'id' => $location->id,
                                            'name' => $location->name,
                                            'price' => $locationData->price,
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

            return view('core::checkout.index', [
                'shipping_address' => $shipping_addresses[0],
                'billing_address' => $billing_addresses[0],
                'cart' => init_cart(),
                'shipping_choices' => $choices,
            ]);
        }

        return view('core::checkout.index', [
            'shipping_address' => $emptyShippingAddress,
            'billing_address' => $emptyBillingAddress,
            'cart' => init_cart(),
        ]);
    }

    public function paymentPage(Request $request)
    {
        $order = Order::where('state', 10)
            ->where('id', $request->session()->get('order_id'))
            ->first();

        if (!$order) {
            return redirect()
                ->route('store.404');
        }

        $onbilgi = Page::where('slug', 'on-bilgilendirme-formu')
            ->first();
        $mesafeli = Page::where('slug', 'mesafeli-satis-sozlesmesi')
            ->first();

        if (!$onbilgi) {
            $onbilgi = "Ön Bilgilendirme Formu bulunamadı..."; 
        } else {
            $onbilgi = format_content_with_order_data($onbilgi->content, $order);
        }

        if (!$mesafeli) {
            $mesafeli = "Mesafeli Satış Sözleşmesi bulunamadı..."; 
        } else {
            $mesafeli = format_content_with_order_data($mesafeli->content, $order);
        }

        $cart = init_cart();

        return view('core::checkout.payment', compact('order', 'cart', 'onbilgi', 'mesafeli'));
    }

    public function successPage()
    {
        return view('core::checkout.success');
    }

    public function errorPage()
    {
        return view('core::checkout.error');
    }

    public function saveInformation(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                Rule::requiredIf(!Auth::check()),
            ],
            'shipping-first-name' => 'required',
            'shipping-last-name' => 'required',
            'shipping-city' => 'required',
            'shipping-district' => 'required',
            'shipping-neighborhood' => 'required',
            'shipping-address' => 'required',
            'shipping-phone' => 'required',
            'billing-type' => 'required',
            'billing-company-name' => [
                Rule::requiredIf($request->input('billing-type') == 'company'),
            ],
            'billing-company-tax' => [
                Rule::requiredIf($request->input('billing-type') == 'company'),
            ],
            'billing-company-tax-administration' => [
                Rule::requiredIf($request->input('billing-type') == 'company'),
            ],
            'billing-first-name' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-last-name' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-city' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-district' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-neighborhood' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-address' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-phone' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
            'billing-email' => [
                Rule::requiredIf($request->input('shipping-not-same-with-billing') == 'on'),
            ],
        ]);

        $cart = init_cart();

        $order = new Order;

        $shippingDetails = [
            'first_name' => $request->input('shipping-first-name'),
            'last_name' => $request->input('shipping-last-name'),
            'phone' => $request->input('shipping-phone'),
            'email' => Auth::check() ? Auth::user()->email : $request->input('shipping-email'),
            'city' => [
                'id' => $request->input('shipping-city'),
                'name' => locations_get_city($request->input('shipping-city'))->name,
            ],
            'district' => [
                'id' => $request->input('shipping-district'),
                'name' => locations_get_district($request->input('shipping-district'))->name,
            ],
            'neighborhood' => [
                'id' => $request->input('shipping-neighborhood'),
                'name' => locations_get_neighborhood($request->input('shipping-neighborhood'))->name,
            ],
            'address' => $request->input('shipping-address'),
        ];

        if ($request->input('billing-not-same-with-shipping')) {
            if ($request->input('billing-type') == 'personal') {
                $billingDetails = [
                    'first_name' => $request->input('billing-first-name'),
                    'last_name' => $request->input('billing-last-name'),
                    'bill_type' => 'personal',
                    'phone' => $request->input('billing-phone'),
                    'email' => $request->input('billing-email'),
                    'city' => [
                        'id' => $request->input('billing-city'),
                        'name' => locations_get_city($request->input('billing-city'))->name,
                    ],
                    'district' => [
                        'id' => $request->input('billing-district'),
                        'name' => locations_get_district($request->input('billing-district'))->name,
                    ],
                    'neighborhood' => [
                        'id' => $request->input('billing-neighborhood'),
                        'name' => locations_get_neighborhood($request->input('billing-neighborhood'))->name,
                    ],
                    'address' => $request->input('billing-address'),
                ];
            } else {
                $billingDetails = [
                    'company_name' => $request->input('billing-company-name'),
                    'tax_number' => $request->input('billing-company-tax-number'),
                    'tax_administration' => $request->input('billing-company-tax-administration'),
                    'e_bill' => $request->input('e-bill-user'),
                    'bill_type' => 'company',
                    'phone' => $request->input('billing-phone'),
                    'email' => $request->input('billing-email'),
                    'city' => [
                        'id' => $request->input('billing-city'),
                        'name' => locations_get_city($request->input('billing-city'))->name,
                    ],
                    'district' => [
                        'id' => $request->input('billing-district'),
                        'name' => locations_get_district($request->input('billing-district'))->name,
                    ],
                    'neighborhood' => [
                        'id' => $request->input('billing-neighborhood'),
                        'name' => locations_get_neighborhood($request->input('billing-neighborhood'))->name,
                    ],
                    'address' => $request->input('billing-address'),
                ];
            }
        } else {
            if ($request->input('billing-type') == 'personal') {
                $billingDetails = [
                    'first_name' => $request->input('shipping-first-name'),
                    'last_name' => $request->input('shipping-last-name'),
                    'phone' => $request->input('shipping-phone'),
                    'email' => Auth::check() ? Auth::user()->email : $request->input('shipping-email'),
                    'bill_type' => 'personal',
                    'city' => [
                        'id' => $request->input('shipping-city'),
                        'name' => locations_get_city($request->input('shipping-city'))->name,
                    ],
                    'district' => [
                        'id' => $request->input('shipping-district'),
                        'name' => locations_get_district($request->input('shipping-district'))->name,
                    ],
                    'neighborhood' => [
                        'id' => $request->input('shipping-neighborhood'),
                        'name' => locations_get_neighborhood($request->input('shipping-neighborhood'))->name,
                    ],
                    'address' => $request->input('shipping-address'),
                ];
            } else {
                $billingDetails = [
                    'company_name' => $request->input('billing-company-name'),
                    'tax_number' => $request->input('billing-company-tax-number'),
                    'tax_administration' => $request->input('billing-company-tax-administration'),
                    'e_bill' => $request->input('e-bill-user'),
                    'phone' => $request->input('shipping-phone'),
                    'email' => Auth::check() ? Auth::user()->email : $request->input('shipping-email'),
                    'bill_type' => 'company',
                    'city' => [
                        'id' => $request->input('shipping-city'),
                        'name' => locations_get_city($request->input('shipping-city'))->name,
                    ],
                    'district' => [
                        'id' => $request->input('shipping-district'),
                        'name' => locations_get_district($request->input('shipping-district'))->name,
                    ],
                    'neighborhood' => [
                        'id' => $request->input('shipping-neighborhood'),
                        'name' => locations_get_neighborhood($request->input('shipping-neighborhood'))->name,
                    ],
                    'address' => $request->input('shipping-address'),
                ];
            }
        }

        if (Auth::check()) {
            $order->user = Auth::user()->id;

            // check user addresses
            if (!Address::where('user_id', Auth::user()->id)->first()) {
                // save address
                Address::create([
                    'user_id' => Auth::user()->id,
                    'type' => 'shipping',
                    'details' => json_encode($shippingDetails),
                ]);

                Address::create([
                    'user_id' => Auth::user()->id,
                    'type' => 'billing',
                    'details' => json_encode($billingDetails),
                ]);
            }
        } else {
            $order->user = 0;
        }

        $shipping_cost = 0;
        $shipping_provider_name = null;

        $shipping_providers = get_settings('shipment');

        // calculate shipping cost
        foreach ($shipping_providers as $provider) {
            if ($provider->id == $request->input('shipping-provider')) {
                if (isset($provider->locations)) {
                    foreach ($provider->locations as $location) {
                        if ($location->city->id == $shipping_details->city->id &&
                            $location->district->id == $shipping_details->district->id) {
                            if (isset($location->neighborhood)) {
                                if (in_array($shipping_details->neighborhood->id, $location->neighborhood)) {
                                    $shipping_cost = $location->price;
                                    $shipping_provider_name = $provider->name;
                                    break;
                                }
                            } else {
                                $shipping_cost = $location->price;
                                $shipping_provider_name = $provider->name;
                                break;
                            }
                        }
                    } 
                } else {
                    $shipping_cost = $provider->price;
                    $shipping_provider_name = $provider->name;
                    break;
                }
            }
        }

        $order->state = 10;

        $order->meta = [
            'code' => generate_order_code(),
            'items' => $cart->items,
            'total_price' => $cart->total_price + $shipping_cost,
            'coupons' => isset($cart->meta['coupons']) ? $cart->meta['coupons'] : [],
            'shipping_address' => $shippingDetails,
            'billing_address' => $billingDetails,
            'shipping_cost' => $shipping_cost,
            'shipping_provider' => $request->input('shipping-provider'),
            'shipping_provider_name' => $shipping_provider_name,
            'note' => $request->input('order-note'),
        ];

        $order->save();

        $request->session()->put('order_id', $order->id);

        return redirect()
            ->route('store.checkout.payment-page');
    }
}
