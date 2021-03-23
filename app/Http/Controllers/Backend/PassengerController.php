<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PassengerController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth','permission:passengers']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
           $data = Passenger::query();
           if(auth()->user()->hasrole('Owner')){

             $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');
             $passegners = array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray());
             $data->whereIn('id',$passegners);

           }
           return DataTables::of($data->select('*'))
                   ->make(true);
        }
       return view('backend.passenger.index');
    }
}
