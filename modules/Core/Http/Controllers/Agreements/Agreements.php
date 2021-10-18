<?php

namespace Core\Http\Controllers\Agreements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Agreements extends Controller
{
    public function index()
    {
        return view('core::agreements.index');
    }

    public function kvkk()
    {
        return view('core::agreements.kvkk');
    }

    public function satis()
    {
        return view('core::agreements.satis');
    }

    public function cerez()
    {
        return view('core::agreements.cerez');
    }
}
