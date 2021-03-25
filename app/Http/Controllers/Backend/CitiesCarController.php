<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarCities\CreateCarCities;
use App\Models\Car;
use App\Models\CarCities;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CitiesCarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:citiescars'])->only('index');
        $this->middleware(['auth','permission:create-citiescar'])->only('store');
        $this->middleware(['auth','permission:delete-citiescar'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =CarCities::with(['car:id,name','city:name,id,governorate_id'])->whereIn('car_id',auth()->user()->cars->pluck(['id']))->get();
            return DataTables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row){
                     $btn='';
                     if(auth()->user()->can('delete-citiescar'))
                     $btn.= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                      return $btn;
              })
              ->rawColumns(['action'])
              ->make(true);
        }
        $governorates=Governorate::with('cities')->get();
        $cars=Car::whereIn('id',auth()->user()->cars->pluck(['id']))->get();
        return view('backend.citiescar.index',compact('governorates','cars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCarCities $request)
    {
        CarCities::create(['car_id'=>$request->car_id,'city_id'=>$request->city_id]);
        return response()->json(['message'=>'success created'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CarCities::findOrfail($id)->delete();
        return response()->json(['message'=>'success deleted'],200);
    }
}
