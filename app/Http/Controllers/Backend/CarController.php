<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarRequest;
use App\Models\Car;
use App\Models\TypeCar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:cars'])->only('index');
        $this->middleware(['auth', 'permission:create-car'])->only('store');
        $this->middleware(['auth', 'permission:edit-car'])->only(['show', 'update']);
        $this->middleware(['auth', 'permission:delete-car'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::with(['owner:id,name', 'typeCar:id,name']);
            if (auth()->user()->hasRole('Owner')) {
                $data->whereIn('id', auth()->user()->cars->pluck(['id']));
            }
            return DataTables::of($data->select('*'))
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . $row->image_path . '" heigth="50px" width="50px" >';
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status == 1 ? 'checked' : '';
                    return '<input type="checkbox" ' . $status . ' class="changestatus" data-id="' . $row->id . '" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                })
                ->addColumn('public', function ($row) {
                    $public = $row->public == 1 ? 'checked' : '';
                    return '<input type="checkbox" ' . $public . ' class="changepublic" data-id="' . $row->id . '" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                })
                ->addColumn('private', function ($row) {
                    $private = $row->private == 1 ? 'checked' : '';
                    return '<input type="checkbox" ' . $private . ' class="changeprivate" data-id="' . $row->id . '" data-toggle="toggle" data-on="مفعل" data-off="غير مفعل" data-onstyle="success" data-offstyle="danger" >';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('edit-car')) {
                        $btn .= '<a href="javascript:void(0);" class="edit btn btn-primary m-1 btn-sm editcar"  data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('delete-car')) {
                        $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status', 'public', 'private'])
                ->make(true);
        }
        $typecars = TypeCar::all();
        return view('backend.car.index', compact('typecars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        auth()->user()->cars()->create($request->validated());
        return response()->json(['message' => 'Success Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return response()->json(['car' => $car], 200);
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
        $car->update($request->validated());
        return response()->json(['message' => 'Success Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(['message' => 'Success Deleted'], 200);
    }
}
