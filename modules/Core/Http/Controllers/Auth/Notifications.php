<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Notifications extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('panel::notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function delete($id)
    {
        $notifications = auth()->user()->notifications;

        foreach ($notifications as $notification) {
            if ($notification->id == $id) {
                $notification->delete();
                break;
            }
        }

        return redirect()->route('panel.notifications');
    }

    public function details($id)
    {
        $details = null;
        $notifications = auth()->user()->notifications;

        foreach ($notifications as $notification) {
            if ($notification->id == $id) {
                if ($notification->type == 'App\Notifications\OrderSubmitted') {
                    $notification->markAsRead();
                    return redirect()->route('panel.orders.edit', $notification->data['order']['id']);
                    break;
                }
                if ($notification->id == $id) {
                    $notification->markAsRead();
                    $details = $notification;
                    break;
                }
            }
        }

        return view('panel::notification-details', [
            'notification' => $details
        ]);
    }
}
