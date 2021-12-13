<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ProfileSettingRequest;
use Illuminate\Support\Facades\File;
use Image;

class ProfileSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:profile-setting']);
    }

    public function index()
    {
        return view('backend.setting.profile-setting');
    }

    public function store(ProfileSettingRequest $request)
    {
        //TODO refactor this code with delete image and update in User Model

        if (!$request->hasFile('image')) {
            auth()->user()->update($request->validated());
        }
        if ($request->hasFile('image')) {
            $name = 'images/users/' . time() . rand(11111, 99999) . '.png';
            Image::make($request->image)->resize(500, 500)->save(public_path($name));
            //!storage unlike old image
            if (File::exists(public_path(auth()->user()->image))) {
                unlink(public_path(auth()->user()->image));
            }
            auth()->user()->update(['image' => $name] + $request->validated());
        }
        return redirect()->route('profile-setting.index')->with('success', 'Success Changed');
    }
}
