<?php

namespace Core\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Coupon;
use Carbon\Carbon;

class Coupons extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate(10);
        return view('panel::marketing.coupons.index', ['coupons' => $coupons]);
    }

    public function create()
    {
        return view('panel::marketing.coupons.create');
    }

    public function edit($id)
    {
        $coupon = Coupon::where('id', $id)->first();

        return view('panel::marketing.coupons.edit', compact('coupon'));
    }

    public function store(Request $request)
    {
        $code = $request->input('code');
        $description = $request->input('description');
        $type = $request->input('type');
        $discount = $request->input('discount');
        $minCartPrice = $request->input('min-cart-price');
        $minCartItems = $request->input('min-cart-items');
        $maxUsers = $request->input('max-users');
        $maxUserApply = $request->input('max-user-apply');
        $free_shipping = $request->input('free-shipping');
        $expires_at = date_create_from_format('Y-m-d-H:i:s', $request->input('expires-at') . '-00:00:00');

        if ($free_shipping) {
            $free_shipping = true;
        } else {
            $free_shipping = false;
        }

        $meta = [];

        if ($minCartPrice != null) {
            $meta['min_cart_price'] = $minCartPrice;
        }

        if ($minCartItems != null) {
            $meta['min_cart_items'] = $minCartItems;
        }

        if ($maxUsers != null) {
            $meta['max_users'] = $maxUsers;
        }

        if ($maxUserApply != null) {
            $meta['max_user_apply'] = $maxUserApply;
        }

        $coupon = new Coupon;
        $coupon->code = $code;
        $coupon->description = $description;
        $coupon->discount_type = $type;
        $coupon->discount = $discount;
        $coupon->free_shipping = $free_shipping;
        $coupon->expires_at = $expires_at;

        if (count($meta)) {
            $coupon->meta = $meta;
        }

        $coupon->save();

        return redirect()->route('panel.marketing.coupons.index');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $code = $request->input('code');
        $description = $request->input('description');
        $type = $request->input('type');
        $discount = $request->input('discount');
        $minCartPrice = $request->input('min-cart-price');
        $minCartItems = $request->input('min-cart-items');
        $maxUsers = $request->input('max-users');
        $maxUserApply = $request->input('max-user-apply');
        $free_shipping = $request->input('free-shipping');
        $expires_at = date_create_from_format('Y-m-d-H:i:s', $request->input('expires-at') . '-00:00:00');

        if ($free_shipping) {
            $free_shipping = true;
        } else {
            $free_shipping = false;
        }

        $coupon = Coupon::where('id', $id)->first();

        if (!$coupon) {
            return redirect()->route('panel.404');
        }

        $meta = [];

        if ($minCartPrice != null) {
            $meta['min_cart_price'] = $minCartPrice;
        }

        if ($minCartItems != null) {
            $meta['min_cart_items'] = $minCartItems;
        }

        if ($maxUsers != null) {
            $meta['max_users'] = $maxUsers;
        }

        if ($maxUserApply != null) {
            $meta['max_user_apply'] = $maxUserApply;
        }

        $coupon->code = $code;
        $coupon->description = $description;
        $coupon->discount_type = $type;
        $coupon->discount = $discount;
        $coupon->free_shipping = $free_shipping;
        $coupon->expires_at = $expires_at;
        $coupon->meta = $meta;
        $coupon->save();

        return redirect()->route('panel.marketing.coupons.edit', ['id' => $id]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $coupon = Coupon::where('id', $id)->first();

        if (!$coupon) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Coupon not found'
                ], 400);
        }

        $coupon->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'Coupon successfully deleted'
            ], 200);
    }
}
