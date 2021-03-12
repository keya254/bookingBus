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
        $governorates=Governorate::with('cities')->get();
        return view('frontend.home.index',compact('governorates'));
    }

    public function private()
    {
        $cars=Car::with('owner')->private()->paginate(8);
        $governorates=Governorate::with('cities')->get();
        return view('frontend.private.index',compact('governorates','cars'));
    }
}
