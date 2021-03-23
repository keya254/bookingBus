<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeCar\TypeCarRequest;
use App\Models\TypeCar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TypeCarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:typecars'])->only('index');
        $this->middleware(['auth','permission:create-typecar'])->only('store');
        $this->middleware(['auth','permission:edit-typecar'])->only(['show','update']);
        $this->middleware(['auth','permission:delete-typecar'])->only('destroy');
        $this->middleware(['auth','permission:status-typecar'])->only('changestatus');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TypeCar::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('status',function($row){
                        $status=$row->status==1?'checked':'';
                        return '<input type="checkbox" '.$status.' class="changestatus" data-id="'.$row->id.'" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                     })
                    ->addColumn('action', function($row){
                        $btn='';
                        if(auth()->user()->can('edit-typecar'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm edittypecar"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                        }
                        if(auth()->user()->can('delete-typecar'))
                        {
                           $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                        }
                            return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }

        return view('backend.typecar.index');
    }

    /**
     * Change The Status Of TypeCar.
    */
    public function changestatus(Request $request)
    {
        $typecar=TypeCar::findOrFail($request->id);
        $typecar->update(['status'=>!$typecar->status]);
        return response()->json(['message'=>'change successfully'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeCarRequest $request)
    {
       TypeCar::create($request->validated());
       return response()->json(['message'=>'success created'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typecar=TypeCar::findorfail($id);
        return response()->json(['typecar'=>$typecar],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeCarRequest $request, $id)
    {
      TypeCar::findorfail($id)->update($request->validated());
      return response()->json(['message'=>'success updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TypeCar::findorfail($id)->delete();
        return response()->json(['message'=>'success deleted'],200);
    }
}
