<?php

namespace App\Traits;

use App\Models\Seat;
use App\Models\Trip;

trait TimeDriver
{


   /**
    * Get All Trips In Date For Auth User Driver
    *
    **/
   public function trip_driver_in_date($date)
   {
       $trip_driver_in_date  = Trip::where('driver_id',auth()->user()->id)->whereDate($date??now())->count();

       return compact('trip_driver_in_date');
   }

  /**
   * Get All Trips In Month For Auth User Driver
   *
   **/
   public function trip_driver_in_Month($month)
   {
       $trip_driver_in_month  = Trip::where('driver_id',auth()->user()->id)->whereDate($month??now())->count();

       return compact('trip_driver_in_month');
   }

   /**
   * Get All Trips In Year For Auth User Driver
   *
   **/
   public function trip_driver_in_year($year)
   {
        $trip_driver_in_year  = Trip::where('driver_id',auth()->user()->id)->whereDate($year??now())->count();

        return compact('trip_driver_in_year');
   }

   /**
   * Get Count All New Booking Seats In This Date For Auth User Driver
   *
   **/
   public function new_booking_seats_in_date($date=null):array
   {
        $trips  = Trip::where('driver_id',auth()->user()->id)->pluck('id');

        $new_booking_seats_in_date =Seat::whereIn('trip_id',$trips)->whereDate('booking_time',$date??now())->count();

        return compact('new_booking_seats_in_date');
   }

   /**
   * Get Count All New Booking Seats In This Month For Auth User Driver
   *
   **/
   public function new_booking_seats_in_month($month=null)
   {
        $trips  = Trip::where('driver_id',auth()->user()->id)->pluck('id');

        $new_booking_seats_in_month = Seat::whereIn('trip_id',$trips)->whereMonth('booking_time',$month??now())->count();

        return compact('new_booking_seats_in_month');
   }

   /**
   * Get Count All New Booking Seats In This Year For Auth User Driver
   *
   **/
   public function new_booking_seats_in_year($year=null)
   {
        $trips  = Trip::where('driver_id',auth()->user()->id)->pluck('id');

        $new_booking_seats_in_year = Seat::whereIn('trip_id',$trips)->whereYear('booking_time',$year??now())->count();

        return compact('new_booking_seats_in_year');
   }
}
