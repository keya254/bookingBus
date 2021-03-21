<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;

trait TimeOwner
{

    /**
    * Get All Trips In Date For Auth User Owner
    *
    **/
    public function trip_owner_in_date($date)
    {
        $trip_owner_in_date  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->whereDate($date??now())->count();

        return compact('trip_owner_in_date');
    }

    /**
    * Get All Trips In Month For Auth User Owner
    *
    **/
    public function trip_owner_in_month($month)
    {
        $trip_owner_in_month  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->whereDate($month??now())->count();

        return compact('trip_owner_in_month');
    }

    /**
    * Get All Trips In Year For Auth User Owner
    *
    **/
    public function trip_owner_in_year($year)
    {
         $trip_owner_in_year  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->whereDate($year??now())->count();

         return compact('trip_owner_in_year');
    }


    /**
    * Get All Cars In Date For Auth User Owner
    *
    **/
    public function car_owner_in_date($date)
    {
        $car_owner_in_date  = Car::where('id',auth()->user()->cars->pluck(['id']))->whereDate($date??now())->count();

        return compact('car_owner_in_date');
    }

    /**
    * Get All Cars In Month For Auth User Owner
    *
    **/
    public function car_owner_in_month($month)
    {
        $car_owner_in_month  = Car::where('id',auth()->user()->cars->pluck(['id']))->whereDate($month??now())->count();

        return compact('car_owner_in_month');
    }

    /**
    * Get All Cars In Year For Auth User Owner
    *
    **/
    public function car_owner_in_year($year)
    {
         $car_owner_in_year  = Car::where('id',auth()->user()->cars->pluck(['id']))->whereDate($year??now())->count();

         return compact('car_owner_in_year');
    }

    /**
    * Get Count All New Booking Seats In This Date For Auth User Owner
    *
    **/
    public function new_booking_seats_in_date($date=null):array
    {
         $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

         $new_booking_seats_in_date =Seat::whereIn('trip_id',$trips)->whereDate('booking_time',$date??now())->count();

         return compact('new_booking_seats_in_date');
    }

    /**
    * Get Count All New Booking Seats In This Month For Auth User Owner
    *
    **/
    public function new_booking_seats_in_month($month=null)
    {
         $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

         $new_booking_seats_in_month = Seat::whereIn('trip_id',$trips)->whereMonth('booking_time',$month??now())->count();

         return compact('new_booking_seats_in_month');
    }

    /**
    * Get Count All New Booking Seats In This Year For Auth User Owner
    *
    **/
    public function new_booking_seats_in_year($year=null)
    {
         $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

         $new_booking_seats_in_year = Seat::whereIn('trip_id',$trips)->whereYear('booking_time',$year??now())->count();

         return compact('new_booking_seats_in_year');
    }

       /**
   * Get Count All New Passengers In This Date
   *
   **/
  public function new_passengers_in_date($date=null):array
  {
     $trips                  = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

     $passeners              = array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray());

     $new_passengers_in_date = Passenger::whereIn('id',$passeners)->whereDate('created_at',$date??now())->count();

     return compact('new_passengers_in_date');
  }

  /**
   * Get Count All New Passengers In This Month
   *
   **/
  public function new_passengers_in_month($month=null)
  {
    $trips                  = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

    $passeners              = array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray());

    $new_passengers_in_month = Passenger::whereIn('id',$passeners)->whereMonth('created_at',$month??now())->count();

    return compact('new_passengers_in_month');
  }

   /**
   * Get Count All New Passengers In This Year
   *
   **/
  public function new_passengers_in_year($year=null)
  {
    $trips                  = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

    $passeners              = array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray());

    $new_passengers_in_year = Passenger::whereIn('id',$passeners)->whereYear('created_at',$year??now())->count();

    return compact('new_passengers_in_year');
  }
}
