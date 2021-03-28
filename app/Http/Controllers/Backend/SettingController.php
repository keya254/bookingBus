<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:website-setting']);
    }

    public function index()
    {
       $setting=Setting::first();
       return view('backend.setting.index',compact('setting'));
    }

    public function store(SettingRequest $request)
    {
        if(! $request->hasFile('logo'))
        {
            Setting::first()->update($request->validated());
        }
        if($request->hasFile('logo')){
            $name='images/logo/logo.png';
            Image::make($request->logo)->resize(500, 500)->save(public_path($name));
            Setting::first()->update(['logo'=>$name]+$request->validated());
        }
      return redirect()->route('setting.index');
    }

}
