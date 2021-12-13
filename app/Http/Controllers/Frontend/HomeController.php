<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Governorate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $governorates = Governorate::with('cities')->get();
        return view('frontend.home.index', compact('governorates'));
    }

    function private (Request $request) {
        $cars = Car::with(['owner', 'cities'])->active()->private();
        if ($request->city_id) {
            $cars->whereHas('cities', function ($query) use ($request) {
                $query->where('cities.id', $request->city_id);
            });
        } else {
            $cars->has('cities');
        }
        $cars = $cars->paginate(8);
        $governorates = Governorate::with('cities')->get();
        return view('frontend.private.index', compact('governorates', 'cars'));
    }
}
