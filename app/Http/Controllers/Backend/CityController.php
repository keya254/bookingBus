<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateCityRequest;
use App\Http\Requests\City\EditCityRequest;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:citys'])->only('index');
        $this->middleware(['auth','permission:create-city'])->only('store');
        $this->middleware(['auth','permission:edit-city'])->only(['show','update']);
        $this->middleware(['auth','permission:delete-city'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = City::with('governorate:id,name')->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn='';
                           if(auth()->user()->can('edit-city'))
                           $btn.= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editcity"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                           if(auth()->user()->can('delete-city'))
                           $btn.= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $governorates=Governorate::all();
        return view('backend.city.index',compact('governorates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        City::create($request->validated());
        return response()->json(['message'=>'success created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return response()->json(['city'=>$city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(EditCityRequest $request, City $city)
    {
       $city->update($request->validated());
       return response()->json(['message'=>'success updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['message'=>'success deleted']);
    }
}
