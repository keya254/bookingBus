<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\TypeCar;
use App\Models\User;

trait TimeAdmin
{


  /**
   * Get Count All New Passengers In This Date
   *
   **/
  public function new_passengers_in_date($date=null):array
  {
     $new_passengers_in_date = Passenger::whereDate('created_at',$date??now())->count();

     return compact('new_passengers_in_date');
  }

  /**
   * Get Count All New Passengers In This Month
   *
   **/
  public function new_passengers_in_month($month=null)
  {
    $new_passengers_in_month = Passenger::whereMonth('created_at',$month??now())->count();

    return compact('new_passengers_in_month');
  }

   /**
   * Get Count All New Passengers In This Year
   *
   **/
  public function new_passengers_in_year($year=null)
  {
    $new_passengers_in_year = Passenger::whereYear('created_at',$year??now())->count();

    return compact('new_passengers_in_year');
  }

   /**
   * Get Count All New Drivers In This Date
   *
   **/
  public function new_drivers_in_date($date=null):array
  {
     $new_drivers_in_date = User::role('Driver')->whereDate('created_at',$date??now())->count();

     return compact('new_drivers_in_date');
  }

  /**
   * Get Count All New Drivers In This Month
   *
   **/
  public function new_drivers_in_month($month=null)
  {
    $new_drivers_in_month = User::role('Driver')->whereMonth('created_at',$month??now())->count();

    return compact('new_drivers_in_month');
  }

   /**
   * Get Count All New Drivers In This Year
   *
   **/
  public function new_drivers_in_year($year=null)
  {
    $new_drivers_in_year = User::role('Driver')->whereYear('created_at',$year??now())->count();

    return compact('new_drivers_in_year');
  }

  /**
   * Get Count All New Owners In This Date
   *
   **/
  public function new_owner_in_date($date=null):array
  {
     $new_owner_in_date = User::role('Owner')->whereDate('created_at',$date??now())->count();

     return compact('new_owner_in_date');
  }

  /**
   * Get Count All New Owners In This Month
   *
   **/
  public function new_owner_in_month($month=null)
  {
    $new_owner_in_month = User::role('Owner')->whereMonth('created_at',$month??now())->count();

    return compact('new_owner_in_month');
  }

   /**
   * Get Count All New Owners In This Year
   *
   **/
  public function new_owner_in_year($year=null)
  {
    $new_owner_in_year = User::role('Owner')->whereYear('created_at',$year??now())->count();

    return compact('new_owner_in_year');
  }

    /**
   * Get Count All New Cars In This Date
   *
   **/
  public function new_car_in_date($date=null):array
  {
     $new_car_in_date = Car::whereDate('created_at',$date??now())->count();

     return compact('new_car_in_date');
  }

  /**
   * Get Count All New Cars In This Month
   *
   **/
  public function new_car_in_month($month=null)
  {
    $new_car_in_month = Car::whereMonth('created_at',$month??now())->count();

    return compact('new_car_in_month');
  }

   /**
   * Get Count All New Cars In This Year
   *
   **/
  public function new_car_in_year($year=null)
  {
    $new_car_in_year = Car::whereYear('created_at',$year??now())->count();

    return compact('new_car_in_year');
  }

  /**
   * Get Count All New Trips In This Date
   *
   **/
  public function new_trip_in_date($date=null):array
  {
     $new_trip_in_date = Trip::whereDate('created_at',$date??now())->count();

     return compact('new_trip_in_date');
  }

  /**
   * Get Count All New Trips In This Month
   *
   **/
  public function new_trip_in_month($month=null)
  {
    $new_trip_in_month = Trip::whereMonth('created_at',$month??now())->count();

    return compact('new_trip_in_month');
  }

   /**
   * Get Count All New Trips In This Year
   *
   **/
  public function new_trip_in_year($year=null)
  {
    $new_trip_in_year = Trip::whereYear('created_at',$year??now())->count();

    return compact('new_trip_in_year');
  }

  /**
  * Get Count All New Typecars In This Date
  *
  **/
  public function new_typecar_in_date($date=null):array
  {
    $new_typecar_in_date = TypeCar::whereDate('created_at',$date??now())->count();

    return compact('new_typecar_in_date');
  }

  /**
  * Get Count All New Typecars In This Month
  *
  **/
  public function new_typecar_in_month($month=null)
  {
     $new_typecar_in_month = Typecar::whereMonth('created_at',$month??now())->count();

     return compact('new_typecar_in_month');
  }

  /**
  * Get Count All New Typecars In This Year
  *
  **/
  public function new_typecar_in_year($year=null)
  {
   $new_typecar_in_year = Typecar::whereYear('created_at',$year??now())->count();

   return compact('new_typecar_in_year');
  }

  /**
  * Get Count All New Booking Seats In This Date
  *
  **/
  public function new_booking_seats_in_date($date=null):array
  {
    $new_booking_seats_in_date =Seat::whereDate('booking_time',$date??now())->count();

    return compact('new_booking_seats_in_date');
  }

  /**
  * Get Count All New Booking Seats In This Month
  *
  **/
  public function new_booking_seats_in_month($month=null)
  {
   $new_booking_seats_in_month = Seat::whereMonth('booking_time',$month??now())->count();

   return compact('new_booking_seats_in_month');
  }

  /**
  * Get Count All New Booking Seats In This Year
  *
  **/
  public function new_booking_seats_in_year($year=null)
  {
   $new_booking_seats_in_year = Seat::whereYear('booking_time',$year??now())->count();

   return compact('new_booking_seats_in_year');
  }

}
