<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Notifications\NewOwnerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class OwnerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','permission:owners'])->only('index');
        $this->middleware(['auth','permission:create-owner'])->only('store');
        $this->middleware(['auth','permission:delete-owner'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::role('Owner')->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn='';
                           if(auth()->user()->can('delete-owner'))
                           $btn.= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('backend.owner.index');
    }

    public function store(CreateUserRequest $request)
    {
        $owner=User::create([
        'name'=>$request->validated()['name'],
        'email'=>$request->validated()['email'],
        'password'=>bcrypt($request->validated()['password'])
        ])->assignRole('Owner');
        Notification::Send($owner,new NewOwnerNotification($owner->name));
        return response()->json(['message'=>'success created'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::FindOrFail($id);
        unlink($user->image);
        $user->delete();
        return response()->json(['message'=>'success deleted'],200);
    }
}
