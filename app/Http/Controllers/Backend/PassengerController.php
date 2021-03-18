<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PassengerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:passengers']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
           $data = Passenger::select('*');
           return DataTables::of($data)
                   ->make(true);
        }
       return view('backend.passenger.index');
    }
}
