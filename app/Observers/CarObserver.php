<?php

namespace App\Observers;

use App\Models\Car;
use Illuminate\Support\Facades\File;
use Image;

class CarObserver
{
    /**
     * Handle the Car "creating" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */
    public function creating(Car $car)
    {
        if (request()->hasFile('image')) {
            $name = 'images/cars/' . time() . rand(11111, 99999) . '.png';
            Image::make(request()->image)->resize(500, 500)->save(public_path($name));
            $car->image = $name;
        }
    }

    /**
     * Handle the Car "updating" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */
    public function updating(Car $car)
    {
        if (request()->hasFile('image')) {
            if (File::exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }

            $name = 'images/cars/' . time() . rand(11111, 99999) . '.png';
            Image::make(request()->image)->resize(500, 500)->save(public_path($name));
            $car->image = $name;
        }

    }

    /**
     * Handle the Car "deleting" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */
    public function deleting(Car $car)
    {
        if (File::exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }
    }
}
