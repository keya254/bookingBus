<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:website-setting']);
    }

    public function index()
    {
        $setting = Setting::first();
        return view('backend.setting.index', compact('setting'));
    }

    public function store(SettingRequest $request)
    {
        Setting::first()->update($request->validated());
        return redirect()->route('setting.index');
    }

}
