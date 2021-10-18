<?php

namespace App\Services;

use Core\Models\Auth\User;
use Core\Models\Order;
use Carbon\Carbon;

class Analytics
{

    public function getTodaysSignups()
    {
        return User::where('created_at', '>=', Carbon::today())->where('created_at', '<', Carbon::tomorrow())->count();
    }

    public function getTodaysVisitors()
    {
        return 0;
    }

    public function getTodaysOrders()
    {
        return Order::where('created_at', '>=', Carbon::today())
            ->where('created_at', '<', Carbon::tomorrow())
            ->where('state', '!=', 10)
            ->count();
    }

    public function getTodaysTransactions()
    {
        return 0;
    }
}
