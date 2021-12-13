<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:change-password']);
    }

    public function index()
    {
        return view('backend.setting.change-password');
    }

    public function store(ChangePasswordRequest $request)
    {
        auth()->user()->update($request->validated());
        return back()->with('success', 'Success Changed');
    }
}
