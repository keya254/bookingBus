<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:notifications']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = auth()->user()->notifications()->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->read_at == null) {
                        $btn .= '<a href="javascript:void(0);" class="read btn btn-primary m-1 btn-sm" data-id="' . $row->id . '">read</a>';
                    }
                    $btn .= '<a href="javascript:void(0);" class="delete btn btn-danger m-1 btn-sm" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.notification.index');
    }

    public function store(Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->id)->first();
        if (!$notification) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $notification->update(['read_at' => now()]);
        return response()->json(['message' => 'Success Changed'], 200);

    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if (!$notification) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $notification->delete();
        return response()->json(['message' => 'Success Deleted'], 200);
    }

}
