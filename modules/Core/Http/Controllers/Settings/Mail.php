<?php

namespace Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Mail extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $settings = get_settings('email');
        return view('panel::settings.mail', compact('settings'));
    }
}
