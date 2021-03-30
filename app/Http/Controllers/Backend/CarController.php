<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarRequest;
use App\Models\Car;
use App\Models\TypeCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Image;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:cars'])->only('index');
        $this->middleware(['auth','permission:create-car'])->only('store');
        $this->middleware(['auth','permission:edit-car'])->only(['show','update']);
        $this->middleware(['auth','permission:delete-car'])->only('destroy');
        $this->middleware(['auth','permission:status-car'])->only('changestatus');
        $this->middleware(['auth','permission:public-car'])->only('changepublic');
        $this->middleware(['auth','permission:private-car'])->only('changeprivate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::with(['owner:id,name','typecar:id,name']);
            if(auth()->user()->hasrole('Owner')){
             $data->whereIn('id',auth()->user()->cars->pluck(['id']));
            }
            return DataTables::of($data->select('*'))
                    ->addIndexColumn()
                    ->addColumn('image',function($row){
                        return '<img src="'.$row->image_path.'" heigth="50px" width="50px" >';
                     })
                     ->addColumn('status',function($row){
                        $status=$row->status==1?'checked':'';
                        return '<input type="checkbox" '.$status.' class="changestatus" data-id="'.$row->id.'" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                     })
                     ->addColumn('public',function($row){
                        $public=$row->public==1?'checked':'';
                        return '<input type="checkbox" '.$public.' class="changepublic" data-id="'.$row->id.'" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                     })
                     ->addColumn('private',function($row){
                        $private=$row->private==1?'checked':'';
                        return '<input type="checkbox" '.$private.' class="changeprivate" data-id="'.$row->id.'" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                     })
                    ->addColumn('action', function($row){
                        $btn='';
                        if(auth()->user()->can('edit-car'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editcar"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                        }
                        if(auth()->user()->can('delete-car'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                        }
                            return $btn;
                    })
                    ->rawColumns(['action','image','status','public','private'])
                    ->make(true);
        }
        $typecars=TypeCar::all();
        return view('backend.car.index',compact('typecars'));
    }

    /**
     * Change The Status Of Car.
    */
    public function changestatus(Request $request)
    {
        $car=Car::findOrFail($request->id);
        if ($car->owner_id==auth()->user()->id) {
            $car->update(['status'=>!$car->status]);
            return response()->json(['message'=>'change successfully'],200);
        }
        return response()->json(['message'=>'Unauthorized'],403);
    }

    /**
     * Change The Public Of Car.
    */
    public function changepublic(Request $request)
    {
        $car=Car::findOrFail($request->id);
        if ($car->owner_id==auth()->user()->id) {
            $car->update(['public'=>!$car->public]);
            return response()->json(['message'=>'change successfully'],200);
        }
        return response()->json(['message'=>'Unauthorized'],403);
    }

    /**
     * Change The Private Of Car.
    */
    public function changeprivate(Request $request)
    {
        $car=Car::findOrFail($request->id);
        if ($car->owner_id==auth()->user()->id) {
            $car->update(['private'=>!$car->private]);
            return response()->json(['message'=>'change successfully'],200);
        }
        return response()->json(['message'=>'Unauthorized'],403);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        if($request->hasFile('image')){
            $name='images/cars/'.time().rand(11111,99999).'.png';
            Image::make($request->validated()['image'])->resize(500, 500)->save(public_path($name));
            auth()->user()->cars()->create(['image'=>$name]+$request->validated());
        }
        else {
            auth()->user()->cars()->create($request->validated());
        }
        return response()->json(['message'=>'success created'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return response()->json(['car'=>$car],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, Car $car)
    {
        if(! $request->hasFile('image'))
        {
            $car->update($request->validated());
        }
        if($request->hasFile('image')){
            $name='images/cars/'.time().rand(11111,99999).'.png';
            Image::make($request->image)->resize(500, 500)->save(public_path($name));
            //!storage unlike old image
            if (File::exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }
            $car->update(['image'=>$name]+$request->validated());
        }
        return response()->json(['message'=>'success update'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //!storage unlike old image
        if (File::exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }
        $car->delete();
        return response()->json(['message'=>'success deleted'],200);
    }
}
