<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ProfileSettingRequest;
use Illuminate\Support\Facades\Storage;
use Image;
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
        if(is_file($request->image)){
            $name='images/users/'.time().rand(11111,99999).'.png';
            Image::make($request->image)->resize(500, 500)->save($name);
            //!storage unlink old image
            unlink(auth()->user()->image);
            auth()->user()->update(['name'=>$request->validated()['name'],'email'=>$request->validated()['email'],'image'=>$name]);
        }
        else {
            auth()->user()->update($request->validated());
        }
        return back()->with('success','change successfully');
    }
}
