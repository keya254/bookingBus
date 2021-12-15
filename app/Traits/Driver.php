<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Seat;
use App\Models\Trip;

trait Driver
{

    /**
     * Get Count All Cars Driver Worked In
     *
     **/
    public function auth_driver_cars():array
    {
        $auth_driver_cars   = count(array_unique(Trip::where('driver_id',auth()->user()->id)->pluck('car_id')->toArray()));

        return compact('auth_driver_cars');
    }

     /**
     * Get Count All Trip Driver Worked In
     *
     **/
    public function auth_driver_trips():array
    {
        $auth_driver_trips            = Trip::where('driver_id',auth()->user()->id)->count();
        $active_auth_driver_trips     = Trip::where('driver_id',auth()->user()->id)->active()->count();
        $inactive_auth_driver_trips   = Trip::where('driver_id',auth()->user()->id)->inactive()->count();

        return compact('auth_driver_trips','active_auth_driver_trips','inactive_auth_driver_trips');
    }

    /**
     * Get Count All Seats In Driver Trip
     *
     **/
    public function auth_driver_seats():array
    {
        $trips                       = Trip::where('driver_id',auth()->user()->id)->pluck('id');
        $auth_driver_seats           = Seat::whereIn('trip_id',$trips)->count();
        $active_auth_driver_seats    = Seat::whereIn('trip_id',$trips)->active()->count();
        $inactive_auth_driver_seats  = Seat::whereIn('trip_id',$trips)->inactive()->count();

        return compact('auth_driver_seats','active_auth_driver_seats','inactive_auth_driver_seats');
    }

    /**
     * Get Count All Cities Driver Worked In
     *
     **/
    public function auth_driver_cities():array
    {
        $from = Trip::where('driver_id',auth()->user()->id)->pluck('from_id');
        $to   = Trip::where('driver_id',auth()->user()->id)->pluck('to_id');
        $cities= $from->merge($to);
        $auth_driver_cities  = City::whereIn('id',$cities)->count();

        return compact('auth_driver_cities');
    }


    /**
     * Get All Information To Auth User Driver
     *
     * Combine All Previous Data
     **/
    public function driver_all():array
    {
       return  $this->auth_driver_trips() + $this->auth_driver_cars() + $this->auth_driver_seats() + $this->auth_driver_cities();
    }

}
