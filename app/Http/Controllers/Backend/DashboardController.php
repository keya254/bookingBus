<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\AdminTrait\Admin;
use app\Traits\DriverTrait\Driver;
use app\Traits\OwnerTrait\Owner;

class DashboardController extends Controller
{
    use Admin,Owner,Driver;

    // public function __construct()
    // {
    //     $this->middleware(['auth','permission:dashboard']);
    // }

    public function index()
    {
        $data=[];
        if (auth()->user()->HasRole('Admin')  || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->admin_all();
        }
        if (auth()->user()->HasRole('Owner')  || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->owner_all();
        }
        if (auth()->user()->HasRole('Driver') || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->driver_all();
        }
        return view('backend.dashboard.index',compact('data'));
    }
}
