<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Core\Models\Auth\User;
use App\Notifications\ContactMessage;

class Contact extends Controller
{
    public function index()
    {
        return view('core::contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'captcha' => 'required|captcha',
        ]);

        // Get required information
        if (Auth::check()) {
            $fullName = Auth::user()->full_name;
            $phone = Auth::user()->phone;
        } else {
            $fullName = $request->input('full_name');
            $phone = $request->input('phone');
        }

        $message = $request->input('message');

        // Send message to the panel admins
        foreach (User::where('role', 'admin')->get() as $user) {
            $user->notify(new ContactMessage($fullName, $phone, $message));
        }

        // redirect to contact page with success message
        return redirect()
            ->route('store.contact.index')
            ->with('form_success', 'Mesajınız başarıyla iletildi');
    }
}
