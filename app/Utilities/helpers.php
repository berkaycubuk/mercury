<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Core\Models\Setting;
use Core\Models\Cart;
use Core\Models\Media;
use Core\Models\Product\Product;
use Core\Models\Order;
use Core\Models\Location\City;
use Core\Models\Location\District;
use Core\Models\Location\Neighborhood;

if (!function_exists('format_content_with_order_data')) {
    function format_content_with_order_data($content, $order) {
        // Receiver Name
        $content = str_replace(
            "{__aliciad__}",
            $order->meta['shipping_address']['first_name'],
            $content
        );

        // Receiver Last Name
        $content = str_replace(
            "{__alicisoyad__}",
            $order->meta['shipping_address']['last_name'],
            $content
        );

        // Receiver Phone
        $content = str_replace(
            "{__alicitelefon__}",
            $order->meta['shipping_address']['phone'],
            $content
        );

        // Receiver Mail
        $content = str_replace(
            "{__alicimail__}",
            $order->meta['shipping_address']['email'],
            $content
        );

        // Payment Table 
        $paymentTable = "<table>";

        $paymentTable .= "<tr>";
        $paymentTable .= "<th>Ürün Adı</th>";
        $paymentTable .= "<th>Adet</th>";
        $paymentTable .= "<th>Birim Fiyat</th>";
        $paymentTable .= "<th>Ara Toplam (KDV Dahil)</th>";
        $paymentTable .= "</tr>";

        $totalOrderPrice = 0;

        foreach ($order->meta['items'] as $item) {
            $paymentTable .= "<tr>";
            $paymentTable .= "<td>" . $item['title'] . "</td>";
            $paymentTable .= "<td>" . $item['amount'] . "</td>";
            $paymentTable .= "<td>" . format_money($item['price']) . "</td>";
            $paymentTable .= "<td>" . format_money($item['price'] + $item['tax'])  . "</td>";
            $paymentTable .= "</tr>";

            $totalOrderPrice += $item['price'] + $item['tax'];
        }

        $paymentTable .= "<tr>";
        $paymentTable .= "<td>Kargo:</td>";
        $paymentTable .= "<td>" . format_money($order->meta['shipping_cost']) . "</td>";
        $paymentTable .= "</tr>";

        $paymentTable .= "<tr>";
        $paymentTable .= "<td>Toplam:</td>";
        $paymentTable .= "<td>" . format_money($totalOrderPrice + $order->meta['shipping_cost']) . "</td>";
        $paymentTable .= "</tr>";

        $paymentTable .= "</table>";

        $content = str_replace("{__odemetablosu__}", $paymentTable, $content);


        // Receiver Address
        $content = str_replace(
            "{__teslimatadresi__}",
            $order->meta['shipping_address']['address'] . ' ' .
            $order->meta['shipping_address']['district']['name'] . ' / ' .
            $order->meta['shipping_address']['city']['name'],
            $content
        );

        // Date
        $content = str_replace("{__tarih__}", date('d.m.Y'), $content);

        return $content;
    }
}

if (!function_exists('updateDotEnv')) {
    function updateDotEnv($key, $newValue, $delim='')
    {
        $path = base_path('.env');
        // get old value from current env
        $oldValue = env($key);

        // was there any change?
        if ($oldValue === $newValue) {
            return;
        }

        // rewrite file content with changed data
        if (file_exists($path)) {
            // replace current value with new value
            file_put_contents(
                $path, str_replace(
                    $key.'='.$delim.$oldValue.$delim,
                    $key.'='.$delim.$newValue.$delim,
                    file_get_contents($path)
                )
            );
        }
    }
}

if (!function_exists('locations_get_city')) {
    function locations_get_city($cityId)
    {
        return City::where('id', $cityId)->first();
    }
}

if (!function_exists('locations_get_cities')) {
    function locations_get_cities()
    {
        return City::all();
    }
}

if (!function_exists('locations_get_district')) {
    function locations_get_district($districtId)
    {
        return District::where('id', $districtId)->first();
    }
}

if (!function_exists('locations_get_districts')) {
    function locations_get_districts($city_id)
    {
        return District::where('city_id', $city_id)->get();
    }
}

if (!function_exists('locations_get_neighborhood')) {
    function locations_get_neighborhood($neighborhoodId)
    {
        return Neighborhood::where('id', $neighborhoodId)->first();
    }
}

if (!function_exists('locations_get_neighborhoods')) {
    function locations_get_neighborhoods($district_id)
    {
        return Neighborhood::where('district_id', $district_id)->get();
    }
}

if (!function_exists('format_money')) {
    function format_money($price)
    {
        return number_format($price, 2, ",", ".") . '₺';
    }
}

if (!function_exists('generate_order_code')) {
    function generate_order_code($limit=9)
    {
        $code = '';
        $orders = Order::all()->pluck("meta.code")->toArray();

        for ($i = 0; $i < $limit; $i++) {
            $rand_num = mt_rand(0, 9);

            while ($i == 0 && $rand_num == 0) {
                $rand_num = mt_rand(0, 9);
            }

            $code .= $rand_num;
        }

        if (!in_array($code, $orders)) {
            return $code;
        } else {
            return generate_order_code();
        }
    }
}

if (!function_exists('get_branch_name')) {
    function get_branch_name($key)
    {
        $branches = get_settings('branches');

        $branchData = null;

        foreach ($branches as $branch) {
            if ($branch->id == $key) {
                $branchData = $branch;
                break;
            }
        }

        return $branchData;
    }
}

if (!function_exists('get_settings')) {
    // Get settings from db
    function get_settings($key, $returnModel = false)
    {
        $settings = Setting::where('key', '=', $key)->first();

        if (!$settings) {
            return null;
        }

        if ($returnModel) {
            return $settings;
        }

        $settings = json_decode($settings->value);

        return $settings;
    }
}

if (!function_exists('get_image')) {
    function get_image($id)
    {
        if ($id == 0) {
            return asset('assets/img/no-image.jpg');
        }

        $image = Media::where('id', '=', $id)->first();

        if (!$image) {
            return asset('assets/img/no-image.jpg');
        }

        return asset($image->path);
    }
}

if (!function_exists('init_cart')) {
    function init_cart()
    {
        $cart_user_id = "";

        if (!empty(auth()->user())) {
            $cart_user_id = auth()->user()->id;
        } else {
            $cart_user_id = Cookie::get('guest_id');
            if (!$cart_user_id) {
                $cart_user_id = md5(rand());
                Cookie::queue('guest_id', $cart_user_id);
            }
        }

        $cart = Cart::where('user', '=', $cart_user_id)->first();

        if (!$cart) {
            $cart = Cart::create(['user' => $cart_user_id]);
        }

        return $cart;
    }
}

if (!function_exists('get_cart_total_items')) {
    function get_cart_total_items()
    {
        $cart = init_cart();
        return $cart->total_items;
    }
}

if (!function_exists('get_cart_total')) {
    function get_cart_total()
    {
        $cart = init_cart();
        return $cart->total_price;
    }
}

if (!function_exists('get_cart_items')) {
    function get_cart_items()
    {
        $cart = init_cart();
        return json_decode($cart->items);
    }
}

if (!function_exists('delete_to_cart')) {
    function delete_to_cart($item_id)
    {
        $cart = init_cart();
        $product = Product::where('id', '=', $item_id)->first();

        if (!$product) {
            return;
        }

        $items = json_decode($cart->items);

        $found = false;

        foreach($items as $key => $item) {
            if ($item->id == $item_id) {
                if ($item->amount > 1) {
                    $item->amount -= 1;
                    // $items[$key] = $item;
                } else {
                    // delete
                   unset($items[$key]);
                }
                $found = true;
            }
        }

        if (!$found) {
            return false;
        }

        $cart->total_items -= 1;
        $cart->total_price -= $product->price;
        $cart->items = json_encode($items);
        $cart->save();

        return true;
    }
}

if (!function_exists('add_to_cart')) {
    function add_to_cart($item_id)
    {
        $cart = init_cart();
        $product = Product::where('id', '=', $item_id)->first();

        if (!$product) {
            return;
        }

        $items = json_decode($cart->items);

        $found = false;

        foreach($items as &$item) {
            if ($item->id == $item_id) {
                $item->amount += 1;
                $found = true;
            }
        }

        if (!$found) {
            array_push($items, [
                'id' => $item_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->images != null ? $product->images[0] : 0,
                'tax' => isset($product->meta['tax']) ? ($product->price * $product->meta['tax']) / 100 : 0,
                'tax_rate' => isset($product->meta['tax']) ? $product->meta['tax'] : 0,
                'amount' => 1
            ]);
        }

        $cart->total_items += 1;
        $cart->total_price += $product->price;
        $cart->items = json_encode($items);
        $cart->save();

        return true;
    }
}
