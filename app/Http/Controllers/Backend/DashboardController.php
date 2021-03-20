<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Traits\AdminTrait\Admin;
use app\Traits\DriverTrait\Driver;
use app\Traits\OwnerTrait\Owner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Admin,Owner,Driver;

    public function __construct()
    {
        $this->middleware(['auth','permission:dashboard']);
    }

    public function index()
    {
        $data= $this->admin_all() + $this->driver_all() + $this->owner_all();

        return view('backend.dashboard.index',compact('data'));
    }
}
