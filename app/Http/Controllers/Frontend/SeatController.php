<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //check the trip is found
        $this->validate($request, ['id' => 'required|exists:trips,id']);
        //get all seats to trip
        $seats = Seat::where('trip_id', $request->id)->select(['id', 'name', 'status'])->orderby('id')->get();
        $trip = Trip::where('id', $request->id)->select(['id', 'max_seats'])->first();
        $trip->setAppends([]);
        return response()->json(['trip' => $trip, 'seats' => $seats], 200);
    }
}
