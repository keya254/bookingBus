<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;

/**
 * For Dates Owner
 */
trait DatesOwner
{

   /**
   * Get Count All New Trips In This Date | Month  | Year For Auth User Owner
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_trips_for_owners($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_trips_for_owners_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Trip::whereIn('car_id',auth()->user()->cars->pluck(['id']))->$condition('created_at',$date??now())->count();

     return compact($variable);
  }


  /**
   * Get Count All New Cars In This Date | Month  | Year For Auth User Owner
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_cars_for_owners($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_cars_for_owners_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Car::whereIn('id',auth()->user()->cars->pluck(['id']))->$condition('created_at',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Booking Seats In This Date | Month  | Year For Auth User Owner
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_booking_seats_for_owners($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_booking_seats_for_owners_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

     $$variable = Seat::whereIn('trip_id',$trips)->$condition('booking_time',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Passengers In This Date | Month  | Year For Auth User Owner
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_passengers_for_owners($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_passengers_for_owners_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $trips  = Trip::where('car_id',auth()->user()->cars->pluck(['id']))->pluck('id');

     $passeners = array_unique(Seat::whereIn('trip_id',$trips)->where('passenger_id','!=',null)->pluck('passenger_id')->toArray());

     $$variable = Passenger::whereIn('id',$passeners)->$condition('created_at',$date??now())->count();

     return compact($variable);
  }

   /**
   * Get All Information In Date|Month|Year For Auth User Owner
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function all_owner_date($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     return
      $this->new_cars_for_owners($type,$date) +  $this->new_booking_seats_for_owners($type,$date) +
      $this->new_passengers_for_owners($type,$date) + $this->new_trips_for_owners($type,$date);

     ;
  }


}

