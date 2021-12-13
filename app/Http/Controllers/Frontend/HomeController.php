<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Governorate;

class HomeController extends Controller
{
    public function __invoke()
    {
        $governorates = Governorate::with('cities')->get();
        return view('frontend.home.index', compact('governorates'));
    }
}
