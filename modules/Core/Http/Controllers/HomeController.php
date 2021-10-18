<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use Core\Models\Product\Product;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;
use Core\Models\User;
use Core\Models\Order;
use Core\Models\Page;
use Blog\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RenewPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Core\Models\Coupon;

class HomeController extends Controller
{
    public function index()
    {
        init_cart();

        $products = Product::where('id', '!=', 0)->orderBy('id', 'DESC')->get();

        $posts = Post::all();

        $new_products = [];

        $counter = 0;

        foreach($products as $product) {
            if (isset($product->meta['online_orderable']) && $product->meta['online_orderable'] && $counter < 8) {
                $counter++;
                array_push($new_products, $product);
            }
        }

        return view("core::index", [
            "new_products" => $new_products,
            "posts" => $posts,
        ]);
    }

    public function searchbarQuery(Request $request)
    {
        $request->validate([
            'query' => 'required',
        ]);

        $query = $request->input('query');

        $results = Product::query()
            ->where('title', 'LIKE', "%{$query}%")
            ->get();

        return view('core::search-results', [
            'query' => $query,
            'results' => $results,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('store.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function renewPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function renewPasswordView()
    {
        return view("core::renew-password");
    }

    public function products($slug)
    {
        if (strpos($slug, '-c-')) { // category
            $slug_arr = explode('-c-', $slug);
            $category = ProductCategory::where('slug', $slug_arr[0])->where('id', $slug_arr[1])->first();

            if (!$category) {
                return redirect()->route('store.404');
            }

            $data = [
                'category' => $category
            ];
        } else if (strpos($slug, '-sc-')) { // subcategory
            $slug_arr = explode('-sc-', $slug);
            $subcategory = Subcategory::where('slug', $slug_arr[0])->where('id', $slug_arr[1])->first();

            if (!$subcategory) {
                return redirect()->route('store.404');
            }

            $data = [
                'category' => $subcategory->product_category,
                'subcategory' => $subcategory
            ];
        } else {
            return redirect()->route('store.404');
        }

        return view('core::products', ['data' => $data]);
    }

    public function page($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();

        if (!$page) {
            return redirect()
                ->route('store.404');
        }

        $site_meta = [
            'title' => $page->title
        ];

        // Commands
        if (strstr($page->content, "[products=")) {
            $string = explode("=", strstr($page->content, "[products="));
            $string[1] = strstr($string[1], ']', true);
            $parameters = explode(",", $string[1]);

            if ($parameters[0] == 'category') {
                $category = ProductCategory::where('slug', $parameters[1])->first();

                if ($category) {
                    $products = Product::where('category', $category->id)->get();

                    return view("core::pages.product", ["page" => $page, 'site_meta' => $site_meta, "products" => $products]);
                } else {
                    return redirect()->route('store.index');
                }
            } else {
                $subcategory = Subcategory::where('slug', $parameters[1])->first();

                if ($subcategory) {
                    $products = Product::where('subcategory', $subcategory->id)->get();

                    return view("core::pages.product", ["page" => $page, 'site_meta' => $site_meta, "products" => $products]);
                } else {
                    return redirect()->route('store.index');
                }
            }

            return;
        } else if (strstr($page->content, "[products]")) {
            $products = Product::all();

            return view("core::pages.products", ["page" => $page, 'site_meta' => $site_meta, "products" => $products]);
        }

        return view("core::page", ["page" => $page, 'site_meta' => $site_meta]);
    }

    /**
     * Display account page
     *
     * @return Response
     */
    public function account()
    {
        $site_meta = [
            'title' => 'Hesabım'
        ];

        return view("core::auth.account", ['site_meta' => $site_meta]);
    }

    public function orders()
    {
        $orders = Order::where("user", "=", Auth::id())->orderBy('id', 'DESC')->get();

        return view("core::orders", [
            "orders" => $orders,
        ]);
    }

    public function orderDetails($code)
    {
        $order = Order::where("meta->code", "=", $code)->first();

        if (!$order) {
            return redirect()->route("store.orders");
        }

        return view("core::order-details", [
            "order" => $order,
        ]);
    }

    public function orderSuccess()
    {
        return view("core::order-success");
    }

    public function product($slug)
    {
        $product = Product::where("slug", "=", $slug)->first();

        if (!$product) {
            return redirect()->route("store.index");
        }

        $referredProductAmount = 6;

        $similar_products = Product::where('id', '!=', $product->id)
            ->where('product_category_id', $product->product_category_id)
            ->where('subcategory_id', $product->subcategory_id)
            ->orderBy('id', 'DESC')
            ->get()->take($referredProductAmount);

        if (!count($similar_products)) {
            $similar_products = Product::where('id', '!=', $product->id)
                ->where('product_category_id', $product->product_category_id)
                ->orderBy('id', 'DESC')
                ->get()->take($referredProductAmount);
        }

        if (!count($similar_products)) {
            $similar_products = Product::where('id', '!=', $product->id)
                ->orderBy('id', 'DESC')
                ->get()->take($referredProductAmount);
        }

        $site_meta = [
            'title' => $product->title
        ];

        return view("core::product", [
            "product" => $product,
            "similar_products" => $similar_products,
            "site_meta" => $site_meta
        ]);
    }

    public function stripePayment($id)
    {
        $order = Order::where("id", "=", $id)->first();

        if (!$order || $order->state > 0) {
            return redirect()->route("store.index");
        }

        return view("core::payments.stripe", [
            "order" => $order,
        ]);
    }

    public function checkout()
    {
        return view("core::checkout");
    }

    public function cart()
    {
        $cart = init_cart();

        if (isset($cart->meta['coupons'])) {
            $coupons = Coupon::whereIn('id', $cart->meta['coupons'])->get();
        } else {
            $coupons = [];
        }

        return view("core::cart", compact('cart', 'coupons'));
    }

    public function loginView()
    {
        if (Auth::check()) {
            return redirect()->route('store.index');
        }

        return view("core::login");
    }

    public function registerView()
    {
        if (Auth::check()) {
            return redirect()->route('store.index');
        }

        $kvkk = Page::where('slug', 'kisisel-verilerin-korunmasi-ve-gizlilik-sozlesmesi')
            ->first();

        $uyelik = Page::where('slug', 'uyelik-sozlesmesi')
            ->first();

        if (!$kvkk) {
            $kvkk = "KVKK Aydınlatma Metni Bulunamadı...";
        } else {
            $kvkk = $kvkk->content;
        }

        if (!$uyelik) {
            $uyelik = "Üyelik Sözleşmesi Bulunamadı...";
        } else {
            $uyelik = $uyelik->content;
        }

        return view("core::register", compact('kvkk', 'uyelik'));
    }

    public function login(Request $request)
    {
        if (
            !Auth::attempt(
                $request->only("email", "password"),
                $request->get("remember", false)
            )
        ) {
            return redirect()
                ->route("store.login")
                ->with("form_error", "User not found.");
        }

        return redirect()->route("store.index");
    }

    public function register(Request $request)
    {
        $request->merge([
            "password" => Hash::make($request->input("password")),
        ]);

        try {
            User::create($request->all());
        } catch (QueryException $e) {
            return redirect()
                ->route("store.register")
                ->with("form_error", "User not created.");
        }

        return redirect()
            ->route("store.register")
            ->with("form_success", "User successfully created.");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("store.index");
    }
}
