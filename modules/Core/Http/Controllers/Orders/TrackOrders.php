<?php

namespace Core\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Order;

class TrackOrders extends Controller
{
    public function search()
    {
        return view('core::search-orders');
    }

    public function query(Request $request)
    {
        $orderCode = $request->input('order-code');

        $order = Order::where('meta->code', $orderCode)->first();

        if (!$order) {
            return redirect()
                ->route('store.track-orders.search');
        }

        return redirect()
            ->route('store.track-orders.result', ['code' => $orderCode]);
    }

    public function result($code)
    {
        $order = Order::where('meta->code', $code)->first();

        if (!$order) {
            return redirect()
                ->route('store.404');
        }

        return view('core::search-order-result', compact('order'));
    }
}
