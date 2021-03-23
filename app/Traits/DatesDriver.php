<?php

namespace App\Traits;

use App\Models\Seat;
use App\Models\Trip;
use Exception;

/**
 *
 */
trait DatesDriver
{
    /**
    * Check The Type Of Date In ['Date','Month','Year']
    *
    **/
    private function check_type_date($type)
    {
        if (! in_array(strtolower($type),['date','month','year'])) {
              return throw new Exception("Error Type Of Date Is Wrong Must Be In ['year','month','date'] Type Give '$type'", 1);
           ;
        }
    }

    /**
    * Get All Trips In Date For Auth User Driver
    *
    * @param $type of date
    *
    * @param $date of date can be null if null using now() date
    **/
   public function new_trips_for_driver($type,$date=null):array
   {
        //check if type correct and in this ['year','month','date']
        $this->check_type_date($type);

        $variable="new_trips_for_driver_in_".strtolower($type);

        $condition='Where'.ucfirst(strtolower($type));

        $$variable=Trip::where('driver_id',auth()->user()->id)->$condition('created_at',$date??now())->count();

        return compact($variable);
   }

   /**
   * Get Count All New Booking Seats In This Date|Month|Year For Auth User Driver
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_booking_seats_for_driver($type,$date=null):array
  {
       //check if type correct and in this ['year','month','date']
       $this->check_type_date($type);
       //get all trips for auth driver
       $trips  = Trip::where('driver_id',auth()->user()->id)->pluck('id');

       $variable="new_booking_seats_for_driver_in_".strtolower($type);

       $condition='Where'.ucfirst(strtolower($type));

       $$variable =Seat::whereIn('trip_id',$trips)->$condition('booking_time',$date??now())->count();

       return compact($variable);
  }


   /**
   * Get All Information In Date|Month|Year For Auth User Driver
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function all_driver_date($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     return  $this->new_trips_for_driver($type,$date) +  $this->new_booking_seats_for_driver($type,$date) ;
  }


}
