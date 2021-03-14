<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchRequest;
use App\Models\Governorate;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $trip=Trip::query();
        if ($request->to_id) {
            $trip->where('to_id',$request->to_id);
        }
        if ($request->from_id) {
            $trip->where('from_id',$request->from_id);
        }
        if ($request->day) {
            $trip->where('day',$request->day);
        }
        $trips=$trip->with(['to:id,name','from:id,name','car'])->active()->paginate(3);
        $governorates=Governorate::with('cities')->get();
        return view('frontend.search.index',compact('governorates','trips'));
    }

    public function seats(Request $request)
    {
        //check the trip is found
        $this->validate($request,['id'=>'required|exists:trips,id']);
        // get all seats to trip
        $seats=Seat::where('trip_id',$request->id)->select(['id','name','status'])->get();

        return response()->json(['seats'=>$seats]);
    }
}
