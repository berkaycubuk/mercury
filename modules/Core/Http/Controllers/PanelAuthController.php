<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Core\Models\Auth\User;
use Illuminate\Support\Facades\Hash;

class PanelAuthController extends Controller
{
    public function settings()
    {
        return view('panel::auth.settings', [ 'user' => Auth::user() ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required',
            'branch' => '',
            'new-pass' => '',
            'new-pass-confirmation' => '',
        ]);

        $user = Auth::user();
        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');

        $meta = [
            'branch' => $request->input('branch'),
        ];

        if ($user->meta != null) {
            $user->meta = array_merge($user->meta, $meta);
        } else {
            $user->meta = array_merge([], $meta);
        }

        if (!User::where('id', '!=', $user->id)->where('email', $request->input('email'))->first()) {
            $user->email = $request->input('email');
        }

        if ($request->input('new-pass') != null) {
            // user wants to change password
            if ($request->input('new-pass-confirmation') == null) {
                return redirect()
                    ->route('panel.auth.settings')
                    ->with(
                        "form_error",
                        "Şifre tekrarı eksik!"
                    );
            }

            if ($request->input('new-pass') != $request->input('new-pass-confirmation')) {
                return redirect()
                    ->route('panel.auth.settings')
                    ->with(
                        "form_error",
                        "Şifreler eşleşmiyor!"
                    );
            }

            $user->password = Hash::make($request->input('new-pass'));

            $user->save();

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('store.login');
        }

        $user->save();

        return redirect()
            ->route('panel.auth.settings')
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => "Ayarlar",
                ])
            );
    }
}
