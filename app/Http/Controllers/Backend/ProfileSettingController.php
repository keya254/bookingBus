<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ProfileSettingRequest;

class ProfileSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:profile-setting']);
    }

    public function index()
    {
       return view('backend.setting.profile-setting');
    }

    public function store(ProfileSettingRequest $request)
    {
       auth()->user()->update($request->validated());
       return back()->with('success','change successfully');
    }
}
