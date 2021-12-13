<?php

namespace App\Observers;

use App\Models\Setting;
use Image;

class SettingObserver
{
    /**
     * Handle the Setting "creating" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function creating(Setting $setting)
    {
        if (request()->hasFile('logo')) {
            $name = 'images/logo/logo.png';
            Image::make(request()->logo)->resize(500, 500)->save(public_path($name));
            $setting->logo = $name;
        }
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function updating(Setting $setting)
    {
        if (request()->hasFile('logo')) {
            $name = 'images/logo/logo.png';
            Image::make(request()->logo)->resize(500, 500)->save(public_path($name));
            $setting->logo = $name;
        }
    }
}
