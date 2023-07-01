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
        $notification = Notification::where('notifiable_id', Auth::id())->latest()->get();

        return view('notification', [
            "notifications" => $notification
        ]);
    }

    public function read(string $id) {
        $notification = Notification::whereJsonContains('data->id', $id)->first();
        $notification->read_at = now();
        $confirm = $notification->save();

        if ($confirm) {
            return true;
        } else {
            return false;
        }
    }
    
    public function unread(string $id) {
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
        $notification->delete();
    }
}
