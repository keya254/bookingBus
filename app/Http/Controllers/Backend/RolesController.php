<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:roles'])->only('index');
        $this->middleware(['auth','permission:create-role'])->only('store');
        $this->middleware(['auth','permission:edit-role'])->only(['show','update']);
        $this->middleware(['auth','permission:role-permission'])->only(['getrolepermissions','role_permissions']);
        $this->middleware(['auth','permission:delete-role'])->only('destroy');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::where('name','!=','SuperAdmin')->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn='';
                           $btn.='<a href="javascript:void(0);" class="permissions btn btn-success m-1 btn-sm" data-id="'.$row->id.'"> اعطاء صلاحيات '.$row->name.'</a>';
                           if(auth()->user()->can('edit-role'))
                           $btn.='<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editrole"  data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';
                           if(auth()->user()->can('delete-role'))
                           {$btn.='<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';}
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       return view('backend.roles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:roles'
        ]);
        Role::create(['name'=>$request->name]);
        return response()->json(['data'=>'success updated'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $role=Role::findById($id);
       return response()->json(['data'=>$role],200);
    }

    public function getrolepermissions($id)
    {
       $role=Role::findById($id);
       $permissions=Permission::all();
       $rolepermissions=Role::findById($id)->permissions->pluck('id')->toArray();
       return response()->json(['role'=>$role,'permissions'=>$permissions,'rolepermissions'=>$rolepermissions],200);
    }

    public function role_permissions(Request $request)
    {
      $this->validate($request,[
          'permissions'=>'required|array',
          'permissions.*'=>'required|integer',
          'role_id'=>'required',
      ]);
      $role=Role::findById($request->role_id);
      $role->syncPermissions($request->permissions);
      return response()->json(['success'=>'تم تعديل صلاحيات الوظيفة بنجاح']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|unique:roles,name,'.$id,
        ]);
        DB::table('roles')->where('id',$id)->update(['name'=>$request->name]);
        return response()->json(['data'=>'success updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::findById($id)->delete();
        return response()->json(['data'=>'success deleted'],200);
    }
}
