<?php

namespace Core\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Core\Models\Auth\User;
use Core\Models\Order;

use Carbon\Carbon;

class Home extends Controller
{
    public function index()
    {
        $latest_orders = Order::where('state', '!=', 10)
            ->orderBy('id', 'DESC')->paginate(5);

        return view('panel::index', compact('latest_orders'));
    }
}
