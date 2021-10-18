<?php

namespace Core\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Order;
use Core\Models\Cart;
use Core\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\QueryException;
use App\Notifications\OrderConfirmed;

use Stripe;

class Orders extends Controller
{
    public function index()
    {
        $orders = Order::where('state', '!=', 10)->orderBy('id', 'DESC')->paginate(10);
        return view('panel::orders.index', ['orders' => $orders]);
    }

    public function edit($id)
    {
        $order = Order::where('id', '=', $id)->first();

        if (!$order) {
            return redirect()
                ->route('panel.orders.index')
                ->with('message_error', 'Order not found.');
        }

        return view('panel::orders.edit', ['order' => $order]);
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            $request->merge([
                'user' => Auth::id()
            ]);
        }

        try {
            // create order
            $order = Order::create($request->all());

            // empty the cart
            if (Auth::check()) {
                $cart = Cart::where('user', '=', Auth::id())->first();
            } elseif(Auth::get('guest_id')) {
                $cart = Cart::where('user', '=', Cookie::get('guest_id'))->first();
            } else {
                return redirect()->route('store.index');
            }

            $cart->delete();
        } catch(QueryException $e) {
            return redirect()
                ->route('store.checkout')
                ->with('form_error', 'Order is not created.');
        }

        // successfull redirect to payment page
        return redirect()->route('store.checkout.payment.stripe', ['id' => $order->id]);
    }

    public function stripePayment(Request $request)
    {
        $order = Order::where('id', '=', $request->input('order_id'))->first();

        if (!$order) {
            return redirect()->route('store.index');
        }

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $order->total_price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "#" . $order->id
        ]);

        $order->state = 1;
        $order->save();

        return redirect()->route('store.checkout.success');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $state = $request->input('state');

        try {
            $order = Order::where('id', $id)->first();

            if (!$order) {
                return redirect()
                    ->route('panel.orders.index')
                    ->with('message_error', 'Sipariş bulunamadı!');
            }

            if ($state == 4 && $order->state != 4) {
                // Order confirmed send e-mail
                User::findOrFail($order->user)
                    ->notify(new OrderConfirmed($order));
            }

            if ($state == 4) {
                $order->meta = array_merge($order->meta, [
                    "confirmer_branch" => $request->input('confirmer-branch')
                ]);
            }

            $order->state = $state;
            $order->save();
        } catch(QueryException $e) {
            return redirect()
                ->route('panel.orders.edit', ['id' => $id])
                ->with('form_error', 'Sipariş güncellenemedi!');
        }

        return redirect()
            ->route('panel.orders.edit', ['id' => $id])
            ->with('form_success', 'Sipariş başarıyla güncellendi');
    }

    public function delete($id)
    {
        $order = Order::where('id', '=', $id)->first();

        if (!$order) {
            return redirect()
                ->route('panel.orders.index')
                ->with('message_error', 'Order not found.');
        }

        $order->delete();

        return redirect()
            ->route('panel.orders.index')
            ->with('message_success', 'Order successfully deleted.');
    }
}
