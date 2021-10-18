<?php

namespace Core\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Transaction;
use Core\Models\Order;
use Core\Models\Auth\User;
use Core\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderSubmitted;

class Payments extends Controller
{
    /* public function makePayment(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            'amount' => $request->input('total'),
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => "Make payment and get your stuff."
        ]);

        return redirect()->route('store.checkout.success');
    } */

    public function process(Request $request)
    {
        $validated = $request->validate([
            'card-full-name' => 'required|string',
            'card-number' => 'required|numeric',
            'card-month' => 'required|numeric',
            'card-year' => 'required|numeric',
            'card-cvv' => 'required|numeric',
            'accept-presell-policy' => 'accepted',
            'accept-selling-policy' => 'accepted',
        ]);

        $transaction = new Transaction;
        $transaction->meta = '{}';
        $transaction->save();

        $order_id = $request->input('order-id');
        $card_name = $request->input('card-full-name');
        $card_number = $request->input('card-number');
        $card_month = $request->input('card-month');
        $card_year = $request->input('card-year');
        $card_cvv = $request->input('card-cvv');

        $order = Order::where('id', $order_id)->first();

        if (!$order) {
            return redirect()
                ->route('store.checkout.error');
        }

        $order->state = 0; // paid & waiting to be confirmed
        $order->save();

        if ($request->session()->exists('order_id')) {
            $request->session()->forget('order_id');
        }

        $cart = init_cart();

        // stock management for order items
        foreach ($cart->items as $item) {
            $product = Product::where('id', $item['id'])->first();
            if ($product && isset($product->meta['stock_amount']) && $product->meta['stock_amount'] != null && $product->meta['stock_amount'] != 0) {
                $newMeta = $product->meta;
                $newMeta['stock_amount'] = $product->meta['stock_amount'] - $item['amount'];
                $product->meta = array_merge($product->meta, $newMeta);
                $product->save();
            }
        }

        // delete cart
        $cart->delete();

        // order submitted notification to admins
        $panel_users = User::where('role', 'admin')->get();
        Notification::send($panel_users, new OrderSubmitted($order));

        return redirect()
            ->route('store.checkout.success');
    }
}
