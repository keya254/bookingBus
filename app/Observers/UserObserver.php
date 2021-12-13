<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Image;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        if (request()->hasFile('image')) {
            $name = 'images/users/' . time() . rand(11111, 99999) . '.png';
            Image::make(request()->image)->resize(500, 500)->save(public_path($name));
            $user->image = $name;
        }
    }

    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        if (request()->hasFile('image')) {
            if (File::exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $name = 'images/users/' . time() . rand(11111, 99999) . '.png';
            Image::make(request()->image)->resize(500, 500)->save(public_path($name));
            $user->image = $name;
        }
    }

    /**
     * Handle the User "deleting" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        if (File::exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }
    }

}
