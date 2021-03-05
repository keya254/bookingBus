<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\TripRequest;
use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:trips'])->only('index');
        $this->middleware(['auth','permission:create-trip'])->only('store');
        $this->middleware(['auth','permission:edit-trip'])->only(['show','update']);
        $this->middleware(['auth','permission:delete-trip'])->only('destroy');
        $this->middleware(['auth','permission:status-trip'])->only('changestatus');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Trip::with(['driver:id,name','car:id,name'])->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('status',function($row){
                        $status=$row->status==1?'checked':'';
                        return '<input type="checkbox" '.$status.' class="changestatus" data-id="'.$row->id.'" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                     })
                    ->addColumn('action', function($row){
                        $btn='';
                        if(auth()->user()->can('تعديل قسم'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm edittrip"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                        }
                        if(auth()->user()->can('حذف قسم'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                        }
                            return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        $cars=Car::all();
        $drivers=User::all();
        return view('backend.trip.index',compact('cars','drivers'));
    }

     /**
     * Change The Status Of Trip.
    */
    public function changestatus(Request $request)
    {
        $trip=Trip::findOrFail($request->id);
        $trip->update(['status'=>!$trip->status]);
        return response()->json(['message'=>'change successfully'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripRequest $request)
    {
        Trip::create($request->validated());
        return response()->json(['message'=>'success created'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        return response()->json(['trip'=>$trip],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(TripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());
        return response()->json(['message'=>'success updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->json(['message'=>'success deleted'],200);
    }
}
