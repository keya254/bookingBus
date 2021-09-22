<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\Admin;
use App\Traits\DatesAdmin;
use App\Traits\DatesDriver;
use App\Traits\DatesOwner;
use App\Traits\Driver;
use App\Traits\Owner;

class DashboardController extends Controller
{
    use Admin,Owner,Driver,DatesDriver,DatesAdmin,DatesOwner;

    public function __construct()
    {
        $this->middleware(['auth','permission:dashboard']);
    }

    public function index()
    {
        $data=[];
        if (auth()->user()->HasRole('Admin')  || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->admin_all();
            $data += $this->all_admin_date('date');
            $data += $this->all_admin_date('month');
            $data += $this->all_admin_date('year');
        }
        if (auth()->user()->HasRole('Owner')  || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->owner_all();
            $data += $this->all_owner_date('date');
            $data += $this->all_owner_date('month');
            $data += $this->all_owner_date('year');
        }
        if (auth()->user()->HasRole('Driver') || auth()->user()->HasRole('SuperAdmin')) {
            $data += $this->driver_all();
            $data += $this->all_driver_date('date');
            $data += $this->all_driver_date('month');
            $data += $this->all_driver_date('year');
        }
        return view('backend.dashboard.index',compact('data'));
    }
}
