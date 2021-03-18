<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:notifications']);
    }

    public function index(Request $request)
    {
       if ($request->ajax()) {
           $data = auth()->user()->notifications()->latest();
           return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                       $btn='';
                       $btn.= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
       }
       return view('backend.notification.index');
    }

    public function store(Request $request)
    {
        auth()->user()->notifications()->where('id',$request->id)->update(['read_at'=>now()]);
        return response()->json(['message'=>'success changed']);
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->where('id',$id)->delete();
        return response()->json(['message'=>'success deleted']);
    }

}
