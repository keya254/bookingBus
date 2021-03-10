<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Governorate\CreateGovernorateRequest;
use App\Http\Requests\Governorate\EditGovernorateRequest;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
        $data = Governorate::select('*');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                       $btn='';
                       if(auth()->user()->can('edit-governorate'))
                       $btn.= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editgovernorate"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                       if(auth()->user()->can('delete-governorate'))
                       $btn.= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.governorate.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGovernorateRequest $request)
    {
        Governorate::create($request->validated());
        return response()->json(['message'=>'success created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function show(Governorate $governorate)
    {
        return response()->json(['governorate'=>$governorate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function update(EditGovernorateRequest $request, Governorate $governorate)
    {
        $governorate->update($request->validated());
        return response()->json(['message'=>'success updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        return response()->json(['message'=>'success deleted']);
    }
}
