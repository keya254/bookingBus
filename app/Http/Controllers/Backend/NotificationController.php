<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:notifications']);
    }

    public function index()
    {
       return view('backend.notification.index');
    }

    public function store(Request $request)
    {
        # code...
    }

    public function destroy($id)
    {

    }

}
