<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $governorates=Governorate::with('cities')->get();
        return view('frontend.home.index',compact('governorates'));
    }
}
