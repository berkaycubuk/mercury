<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Display login page
     *
     * @return Response
     */
    public function index()
    {
        return view("core::panel.login");
    }

    /**
     * Authenticate user
     *
     * @return Response
     */
    public function submit(Request $request)
    {
        // Attempt to login
        if (
            !Auth::attempt(
                $request->only("email", "password"),
                $request->get("remember", false)
            )
        ) {
            return redirect()
                // ->route("panel.login")
                ->route('store.login')
                ->with("form_error", 'Hatalı e-posta veya şifre!');
        }

        if (Auth::user()->email_verified_at == null) {
            // user is not verified
            Auth::logout();
            return redirect()
                ->route('store.login')
                ->with('form_error', 'Hesabınızı doğrulamadınız! Lütfen size gönderdiğimiz e-postadaki bağlantıyı kullanarak hesabınızı doğrulayınız.');
        }

        // return redirect()->route("panel.homepage.index");
        if (Auth::user()->role == 'admin') {
            return redirect()->route('panel.homepage.index');
        }

        return redirect()->route('store.index');
    }
}
