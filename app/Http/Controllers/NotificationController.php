<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use App\Models\Notification;
use App\Models\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index() {
        $notifications = Notification::where('notifiable_id', auth()->user()->id)->latest()->get();

        return view('notifications.index', [
            "notifications" => $notifications
        ]);
    }
    
    public function inbox() {
        $notifications = Notification::where('notifiable_id', auth()->user()->id)->latest()->get();

        if (request()->ajax()) {
            return view('notifications.action', ["notifications" => $notifications]);
        } else {
            return view('notifications.index', ["notifications" => $notifications]);
        }
    }
    
    public function read() {
        $notifications = Notification::where('notifiable_id', auth()->user()->id)->where('read_at', '!=', null)->latest()->get();

        if (request()->ajax()) {
            return view('notifications.action', ["notifications" => $notifications]);
        } else {
            return view('notifications.index', ["notifications" => $notifications]);
        }
    }

    public function unread() {
        $notifications = Notification::where('notifiable_id', auth()->user()->id)->where('read_at', null)->latest()->get();

        if (request()->ajax()) {
            return view('notifications.action', ["notifications" => $notifications]);
        } else {
            return view('notifications.index', ["notifications" => $notifications]);
        }
    }


    public function readMessage(string $id) {
        $notification = Notification::whereJsonContains('data->id', $id)->first();
        $notification->read_at = now();
        $confirm = $notification->save();

        if ($confirm) {
            return true;
        } else {
            return false;
        }
    }
    
    public function unreadMessage(string $id) {
        $notification = Notification::whereJsonContains('data->id', $id)->first();
        $notification->read_at = null;
        $confirm = $notification->save();

        if ($confirm) {
            return true;
        } else {
            return false;
        }
    }

    public function store(string $user_id, string $freelancer_id) {
        $notify = new Notify();
        $notify->user_id = $user_id;
        $notify->freelancer_id = $freelancer_id;
        $notify->save();
    }

    public function unstore(string $user_id, string $freelancer_id) {
        $notify = Notify::where('user_id', $user_id)->where('freelancer_id', $freelancer_id)->first();
        $notify->delete();
    }

    public function destroy(string $id) {
        $notification = Notification::whereJsonContains('data->id', $id)->first();
        $confirmDestroy = $notification->delete();

        if ($confirmDestroy) {
            return true;
        } else {
            return false;
        }
    }
}
