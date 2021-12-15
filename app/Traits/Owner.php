<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\CarCities;
use App\Models\OwnerDriver;
use App\Models\Seat;
use App\Models\Trip;

trait Owner
{

    /**
   * Get Count All Cars For Auth User Owner
   *
   **/
  public function auth_owner_cars():array
  {
    $auth_owner_cars           = Car::whereIn('id',auth()->user()->cars->pluck(['id']))->count();
    $active_auth_owner_cars    = Car::whereIn('id',auth()->user()->cars->pluck(['id']))->active()->count();
    $inactive_auth_owner_cars  = Car::whereIn('id',auth()->user()->cars->pluck(['id']))->inactive()->count();

    return compact('auth_owner_cars', 'active_auth_owner_cars' , 'inactive_auth_owner_cars');
  }

  /**
   * Get Count All Trips For Auth User Owner
   *
   **/
  public function auth_owner_trips():array
  {
    $auth_owner_trips           = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->count();
    $active_auth_owner_trips    = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->active()->count();
    $inactive_auth_owner_trips  = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->inactive()->count();

    return compact('auth_owner_trips','active_auth_owner_trips','inactive_auth_owner_trips');
  }

  /**
   * Get Count All Seats For Auth User Owner
   *
   **/
  public function auth_owner_seats():array
  {
    $trips                      = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');
    $auth_owner_seats           = Seat::whereIn('trip_id',$trips)->count();
    $active_auth_owner_seats    = Seat::whereIn('trip_id',$trips)->active()->count();
    $inactive_auth_owner_seats  = Seat::whereIn('trip_id',$trips)->inactive()->count();

    return compact('auth_owner_seats', 'active_auth_owner_seats', 'inactive_auth_owner_seats');
  }

  /**
   * Get Count All Cities For Auth User Owner Private Cars
   *
   **/
  public function auth_owner_private_cities():array
  {
     $auth_owner_private_cities = CarCities::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('city_id')->count();

     return compact('auth_owner_private_cities');
  }

  /**
   * Get Count All Private Car For Auth User Owner
   *
   **/
  public function auth_owner_private_cars():array
  {
    $auth_owner_private_cars     = Car::whereIn('id',auth()->user()->cars->pluck(['id']))->private()->count();

    return compact('auth_owner_private_cars');
  }

  /**
   * Get Count All Drivers For Auth User Owner
   *
   **/
  public function auth_owner_drivers():array
  {
    $auth_owner_drivers   = OwnerDriver::where('owner_id',auth()->user()->id)->count();

    return compact('auth_owner_drivers');
  }

  /**
   * Get Count All Passengers Booking Seats By Phone Number
   *
   **/
  public function auth_owner_passengers():array
  {
    $trips                 = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');
    $auth_owner_passengers  = count(array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray()));

    return compact('auth_owner_passengers');
  }

  /**
   * Get All Information To Auth User Owner
   *
   * Combine All Previous Data
   *
   **/
  public function owner_all()
  {
    return
        $this->auth_owner_cars() + $this->auth_owner_drivers() +
        $this->auth_owner_passengers() + $this->auth_owner_private_cars() +
        $this->auth_owner_private_cities() + $this->auth_owner_seats() +
        $this->auth_owner_trips();
  }
}
