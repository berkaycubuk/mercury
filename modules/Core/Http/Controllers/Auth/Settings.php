<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Core\Models\Auth\User;
use Illuminate\Support\Facades\Hash;

class Settings extends Controller
{
    public function index()
    {
        return view('core::auth.settings', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');

        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->first_name = $first_name;
        $user->last_name = $last_name;

        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function updatePassword(Request $request)
    {
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $new_password_repeat = $request->input('new_password_repeat');

        $user = User::where('id', '=', Auth::user()->id)->first();

        if (!Hash::check($current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Şifreler eşleşmiyor'
            ], 400);
        }

        if ($new_password != $new_password_repeat) {
            return response()->json([
                'success' => false,
                'message' => 'Şifreler eşleşmiyor'
            ], 400);
        }

        $user->password = Hash::make($new_password);

        $user->save();

        return response()->json([
            'success' => true
        ], 200);
    }
}
