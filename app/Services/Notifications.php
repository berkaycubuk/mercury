<?php

namespace App\Services;

use Core\Models\Auth\User;
use Core\Models\Order\Order;
use Carbon\Carbon;

class Notifications
{
    public function getHeaderNotifications()
    {
        return auth()->user()->unreadNotifications;
    }
}
