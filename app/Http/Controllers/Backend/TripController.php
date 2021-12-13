<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\TripRequest;
use App\Models\Car;
use App\Models\Governorate;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\NewTripForDriverNotification;
use App\Notifications\NewTripForOwnerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:trips'])->only('index');
        $this->middleware(['auth', 'permission:create-trip'])->only('store');
        $this->middleware(['auth', 'permission:edit-trip'])->only(['show', 'update']);
        $this->middleware(['auth', 'permission:delete-trip'])->only('destroy');
        $this->middleware(['auth', 'permission:status-trip'])->only('changestatus');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Trip::with(['driver:id,name', 'car:id,name', 'to:id,name', 'from:id,name']);
            if (auth()->user()->hasrole('Owner')) {
                $data->whereIn('car_id', auth()->user()->cars->pluck(['id']));
            }
            if (auth()->user()->hasrole('Driver')) {
                $data->where('driver_id', auth()->user()->driver_id);
            }
            return DataTables::of($data->select('*'))
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = $row->status == 1 ? 'checked' : '';
                    return '<input type="checkbox" ' . $status . ' class="changestatus" data-id="' . $row->id . '" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                })
                ->addColumn('action', function ($row) {
                    $routeseats = route("trip.seats", $row->id);
                    $btn = '';
                    if (auth()->user()->can('edit-trip')) {
                        $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm edittrip"  data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('delete-trip')) {
                        $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    }
                    if (auth()->user()->can('seats-trip')) {
                        $btn .= '<a href="' . $routeseats . '" class="btn btn-success m-1 btn-sm">المقاعد</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $cars = Car::where('owner_id', auth()->user()->id)->get();
        $drivers = User::role('Driver')->whereIn('id', auth()->user()->drivers->pluck(['driver_id']))->get();
        $governorates = Governorate::with('cities')->get();
        return view('backend.trip.index', compact('cars', 'drivers', 'governorates'));
    }

    /**
     * Change The Status Of Trip.
     */
    public function changestatus(Request $request)
    {
        $trip = Trip::findOrFail($request->id);
        if ($trip->car->owner_id == auth()->user()->id) {
            $trip->update(['status' => !$trip->status]);
            return response()->json(['message' => 'Success Changed'], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 403);

    }

    /**
     * get sets information for the trip
     */
    public function seats(Trip $trip)
    {
        $seats = $trip->seats()->with('passenger')->orderBy('id')->get();
        return view('backend.trip.seats', compact('seats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripRequest $request)
    {
        $trip = Trip::create($request->validated());
        Notification::send($trip->car->owner, new NewTripForOwnerNotification($trip));
        Notification::send($trip->driver, new NewTripForDriverNotification($trip));
        return response()->json(['message' => 'Success Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        return response()->json(['trip' => $trip], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(TripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());
        return response()->json(['message' => 'Success Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->json(['message' => 'Success Deleted'], 200);
    }
}
