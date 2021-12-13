<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:permissions'])->only('index');
        $this->middleware(['auth', 'permission:create-permission'])->only('store');
        $this->middleware(['auth', 'permission:edit-permission'])->only(['show', 'update']);
        $this->middleware(['auth', 'permission:delete-permission'])->only('destroy');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('edit-permission')) {
                        $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editpermission"  data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete-permission')) {
                        $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.permissions.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
        ]);
        Permission::create(['name' => $request->name]);
        return response()->json(['data' => 'Success Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findById($id);
        return response()->json(['data' => $permission], 200);
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
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
        ]);
        DB::table('permissions')->where('id', $id)->update(['name' => $request->name]);
        return response()->json(['data' => 'Success Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::findById($id)->delete();
        return response()->json(['data' => 'Success Deleted'], 200);
    }
}
