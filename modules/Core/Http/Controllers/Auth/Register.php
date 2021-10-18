<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Notifications\AccountRegistered;
use Carbon\Carbon;

class Register extends Controller
{
    /**
     * Authenticate user
     *
     * @return Response
     */
    public function submit(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha',
            'accept-rules' => 'accepted',
        ]);

        $request->merge([
            "password" => Hash::make($request->input("password")),
        ]);

        try {
            DB::transaction(function() use ($request) {
                $user = new User;
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                $user->password = $request->input('password');
                $user->activation_code = md5($user->email . date('d.m.Y-h:i:s'));
                $user->save();

                $user->notify(new AccountRegistered($user));
            });
        } catch (QueryException $e) {
            return redirect()
                ->route("store.register")
                ->with("form_error", "Üyelik oluşturulamadı!");
        }

        return redirect()
            ->route("store.register")
            ->with("form_success", "Üyeliğiniz başarıyla oluşturuldu. E-posta adresinize gönderdiğimiz bağlantı ile üyeliğinizi aktifleştirebilirsiniz.");
    }

    public function activate($code, $id)
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::user()->id)->first();

            if ($user->activation_code != $code) {
                return redirect()->route('store.index');
            }

            $user->email_verified_at = Carbon::now();
            $user->save();
        } else {
            $user = User::where('id', $id)->first();

            if ($user->activation_code != $code) {
                return redirect()->route('store.index');
            }

            $user->email_verified_at = Carbon::now();
            $user->save();
        }

        return redirect()
            ->route('store.login')
            ->with('form_success', 'Hesabınız doğrulandı! Giriş yapabilirsiniz');
    }
}
