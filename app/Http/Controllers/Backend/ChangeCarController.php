<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class ChangeCarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:status-car'])->only('changeStatus');
        $this->middleware(['auth', 'permission:public-car'])->only('changePublic');
        $this->middleware(['auth', 'permission:private-car'])->only('changePrivate');
    }

    /**
     * Change The Status Of Car.
     */
    public function changeStatus(Request $request)
    {
        $car = Car::findOrFail($request->id);
        if ($car->owner_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $car->update(['status' => !$car->status]);
        return response()->json(['message' => 'Success Changed'], 200);
    }

    /**
     * Change The Public Of Car.
     */
    public function changePublic(Request $request)
    {
        $car = Car::findOrFail($request->id);
        if ($car->owner_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $car->update(['public' => !$car->public]);
        return response()->json(['message' => 'Success Changed'], 200);
    }

    /**
     * Change The Private Of Car.
     */
    public function changePrivate(Request $request)
    {
        $car = Car::findOrFail($request->id);
        if ($car->owner_id != auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $car->update(['private' => !$car->private]);
        return response()->json(['message' => 'Success Changed'], 200);
    }
}
