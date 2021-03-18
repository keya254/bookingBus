<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        # code...
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:4',
            'phone_number'=>'required|size:11',
            'trip_id'=>'required|exists:trips,id',
            'myseats'=>'required',
        ]);

        //get the trip to get max seats of trip
        $trip=Trip::Where('id',$request->trip_id)->first();
        //create or update the passenger  to check max seats in this trip
        $passenger=Passenger::UpdateOrCreate(['phone_number'=>$request->phone_number],['name'=>$request->name,'phone_number'=>$request->phone_number]);
        //get count seats this passenger in this trip
        $oldseatscount=Seat::Where('trip_id',$request->trip_id)->Where('passenger_id',$passenger->id)->count();
        //get count seats available in this trip
        $availableseats=Seat::Where('trip_id',$request->trip_id)->Where('passenger_id',null)->count();
        //get count seats in booking request convert string to array
        $myseatscount=explode(',',$request->myseats);
        //check max seats in the trip
        if ($trip->max_seats >= ($oldseatscount+count($myseatscount)) &&  $availableseats >= ($oldseatscount+count($myseatscount))) {
            foreach ($myseatscount as $key => $value) {
                //booking if available
                Seat::Where('trip_id',$request->trip_id)->Where('name',$value)->Where('passenger_id',null)->update(['status'=>1,'passenger_id'=>$passenger->id]);
            }
            return response()->json(['message'=>'تم الحجز بنجاح'],200);
        }else
        {
            return response()->json(['message'=>"$trip->max_seats الحد الاقصي  لحجز عدد مقاعد هو"],422);
        }
        return response()->json(['message'=>'حدث خطئ ما'],422);
    }
}
