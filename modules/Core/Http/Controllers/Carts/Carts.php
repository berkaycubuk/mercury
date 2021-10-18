<?php

namespace Core\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\Product;
use Core\Models\Coupon;

class Carts extends Controller
{
    public function add(Request $request)
    {
        $id = $request->input('id');
        $term = $request->input('term');
        $attribute = $request->input('attribute');
        $amount = $request->input('amount');

        $cart = init_cart();
        $product = Product::where('id', '=', $id)->first();

        if (!$product) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 400);
        }

        if (!$product->in_stock) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Product amount not in stock'
                ], 400);
        }

        if ($cart->items != null) {
            $items = $cart->items;
        } else {
            $items = [];
        }

        $found = false;
        $current_item = null;

        $selectedAttribute = null;
        $selectedTerm = null;

        // get selected term details
        if ($term != null && $attribute != null) {
            foreach ($product->meta['attributes'] as $productAttribute) {
                if ($productAttribute['id'] == $attribute) {
                    $selectedAttribute = [
                        'id' => $productAttribute['id'],
                        'name' => $productAttribute['name']
                    ]; 

                    foreach ($productAttribute['terms'] as $productTerm) {
                        if ($productTerm['id'] == $term) {
                            if ($productTerm['price'] == 0) {
                                $productTerm['price'] = $product->price;
                            }
                            $selectedTerm = [
                                'id' => $productTerm['id'],
                                'name' => $productTerm['name'],
                                'price' => $productTerm['price']
                            ];
                            break;
                        }
                    }
                    break;
                }
            }
        }

        // check is item already in the cart
        foreach($items as &$item) {
            if ($item['id'] == $id) {
                // check is it different term or not
                if (isset($item['term']) && isset($item['attribute'])) {
                    if ($item['term']['id'] == $selectedTerm['id'] && $item['attribute']['id'] == $selectedAttribute['id']) {
                        $item['amount'] += $amount;
                        $found = true;
                        $current_item = $item;
                        break;
                    }
                } else {
                    if ($selectedTerm == null || $selectedAttribute == null) {
                        $item['amount'] += $amount;
                        $found = true;
                        $current_item = $item;
                        break;
                    }
                }
            }
        }

        if (!$found) {
            if ($attribute != null && $term != null && isset($product->meta['attributes']) && $product->meta['attributes'] != null) {
                if ($selectedTerm == null || $selectedAttribute == null) {
                    return response()
                        ->json([
                            'success' => false,
                            'message' => 'Term or attribute not found'
                        ], 400);
                }

                $availableShippings = [];

                if (isset($product->meta['available_shippings']) && $product->meta['available_shippings'] != null) {
                    foreach (get_settings('shipment') as $method) {
                        if (in_array($method->id, $product->meta['available_shippings'])) {
                            array_push($availableShippings, $method);
                        }
                    }
                }

                array_push($items, [
                    'id' => $id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $selectedTerm['price'],
                    'attribute' => $selectedAttribute,
                    'term' => $selectedTerm,
                    'image' => $product->images != null ? $product->images[0] : 0,
                    'tax' => isset($product->meta['tax']) ? ($selectedTerm['price'] * $product->meta['tax']) / 100 : 0,
                    'tax_rate' => isset($product->meta['tax']) ? $product->meta['tax'] : 0,
                    'amount' => $amount,
                    'available_shippings' => $availableShippings
                ]);
            } else {
                $availableShippings = [];

                if (isset($product->meta['available_shippings']) && $product->meta['available_shippings'] != null) {
                    foreach (get_settings('shipment') as $method) {
                        if (in_array($method->id, $product->meta['available_shippings'])) {
                            array_push($availableShippings, $method);
                        }
                    }
                }

                array_push($items, [
                    'id' => $id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'image' => $product->images != null ? $product->images[0] : 0,
                    'tax' => isset($product->meta['tax']) ? ($product->price * $product->meta['tax']) / 100 : 0,
                    'tax_rate' => isset($product->meta['tax']) ? $product->meta['tax'] : 0,
                    'amount' => $amount,
                    'available_shippings' => $availableShippings
                ]);
            }
        }

        $cart->items = $items;
        $cart->save();

        if ($current_item) {
            return response()
                ->json([
                    'success' => true,
                    'amount' => $current_item->amount,
                    'cart_total' => format_money($cart->total_price),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->tax),
                ]);
        } else {
            return response()
                ->json([
                    'success' => true,
                    'amount' => $amount,
                    'cart_total' => format_money($cart->total_price),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->tax),
                ]);
        }
    }

    public function remove(Request $request)
    {
        $id = $request->input('id');
        $term = $request->input('term');
        $attribute = $request->input('attribute');

        $cart = init_cart();
        $product = Product::where('id', '=', $id)->first();

        if (!$product) {
            return;
        }

        $items = $cart->items;

        $found = false;

        $current_item = null;

        foreach($items as $key => $item) {
            if ($item['id'] == $id) {
                if (isset($item['term']) && isset($item['attribute'])) {
                    if ($item['term']['id'] == $term && $item['attribute']['id'] == $attribute) {
                        if ($item['amount'] > 1) {
                            $item['amount'] -= 1;
                            // $items[$key] = $item;
                            $current_item = $item;
                        } else {
                            // delete
                            unset($items[$key]);
                        }

                        $found = true;
                    }
                } else {
                    if ($term == null && $attribute == null) {
                        if ($item['amount'] > 1) {
                            $item['amount'] -= 1;
                            // $items[$key] = $item;
                            $current_item = $item;
                        } else {
                            // delete
                            unset($items[$key]);
                        }

                        $found = true;
                    }
                }
            }
        }

        if (!$found) {
            return response()
                ->json([
                    'success' => false,
                    'amount' => 0,
                    'cart_total' => format_money($cart->total_price - $cart->tax),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->total_price),
                ]);
        }

        $cart->items = $items;
        $cart->save();

        if ($current_item) {
            return response()
                ->json([
                    'success' => true,
                    'amount' => $current_item->amount,
                    'cart_total' => format_money($cart->total_price - $cart->tax),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->total_price),
                ]);
        } else {
            return response()
                ->json([
                    'success' => true,
                    'amount' => 0,
                    'cart_total' => format_money($cart->total_price - $cart->tax),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->total_price),
                ]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $cart = init_cart();
        $product = Product::where('id', '=', $id)->first();

        if (!$product) {
            return;
        }

        $items = $cart->items;
        $found = false;

        foreach($items as $key => $item) {
            if ($item['id'] == $id) {
                unset($items[$key]);
                $found = true;
            }
        }

        $cart->items = $items;
        $cart->save();

        if (!$found) {
            return response()
                ->json([
                    'success' => false,
                    'amount' => 0,
                    'cart_total' => format_money($cart->total_price - $cart->tax),
                    'cart_tax' => format_money($cart->tax),
                    'cart_total_without_tax' => format_money($cart->total_price),
                ]);
        }

        return response()
            ->json([
                'success' => true,
                'amount' => 0,
                'cart_total' => format_money($cart->total_price - $cart->tax),
                'cart_tax' => format_money($cart->tax),
                'cart_total_without_tax' => format_money($cart->total_price),
            ]);
    }

    public function emptyCart(Request $request)
    {
        $cart = init_cart();
        $cart->items = [];
        $cart->save();

        return response()
            ->json([
                'success' => true,
                'amount' => 0,
                'cart_total' => format_money($cart->total_price - $cart->tax),
                'cart_tax' => format_money($cart->tax),
                'cart_total_without_tax' => format_money($cart->total_price),
            ]);
    }

    public function deleteCoupon(Request $request)
    {
        $id = $request->input('coupon_id');
        $cart = init_cart();

        if (!$id) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'ID is not defined'
                ], 400);
        }

        $temp = $cart->meta['coupons'];
        
        foreach ($temp as $key => $item) {
            if ($item == $id) {
                unset($temp[$key]);
            }
        }

        $cart->meta = array_replace($cart->meta, [
            'coupons' => $temp
        ]);

        $cart->save();

        return response()
          ->json([
              'success' => true,
              'message' => 'Coupon found and available',
              'cart' => [
                  'total_price_without_tax' => format_money($cart->discounted_total - $cart->discounted_tax),
                  'tax' => format_money($cart->discounted_tax),
                  'total_price' => format_money($cart->discounted_total),
                  'coupons' => $cart->coupons
              ]
          ], 200);
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('code');
        $cart = init_cart();

        if (!$code) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Code is not defined'
                ], 400);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Coupon not found'
                ], 400);
        }

        if ($cart->meta == null) {
            $cart->meta = [];
        }
        
        $cart->meta = array_merge($cart->meta, [
            'coupons' => [$coupon->id]
        ]);

        $cart->save();

        return response()
          ->json([
              'success' => true,
              'message' => 'Coupon found and available',
              'cart' => [
                  'total_price_without_tax' => format_money($cart->discounted_total - $cart->discounted_tax),
                  'tax' => format_money($cart->discounted_tax),
                  'total_price' => format_money($cart->discounted_total),
                  'coupons' => $cart->coupons
              ]
          ], 200);
    }
}
