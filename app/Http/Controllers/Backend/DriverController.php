<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Notifications\NewDriverNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:drivers'])->only('index');
        $this->middleware(['auth', 'permission:create-driver'])->only('store');
        $this->middleware(['auth', 'permission:delete-driver'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::role('Driver');
            if (auth()->user()->hasrole('Owner')) {
                $data->whereIn('id', auth()->user()->drivers->pluck(['driver_id']));
            }
            return DataTables::of($data->select('*'))
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('delete-driver')) {
                        $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.driver.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $driver = User::create($request->validated())->assignRole('Driver');
        auth()->user()->drivers()->create(['driver_id' => $driver->id]);
        Notification::Send($driver, new NewDriverNotification($driver->name));
        return response()->json(['message' => 'Success Created'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::FindOrFail($id);
        if (!auth()->user()->drivers()->where('driver_id', $id)->first()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user->delete();
        return response()->json(['message' => 'Success Deleted'], 200);
    }
}
