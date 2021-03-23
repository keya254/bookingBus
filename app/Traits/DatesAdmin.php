<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\TypeCar;
use App\Models\User;

/**
 * Date For Admin
 */
trait DatesAdmin
{
   /**
   * Get Count All New Passengers In This Date | Month  | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_passengers($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_passengers_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Passenger::$condition('created_at',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Drivers In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_drivers($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_drivers_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = User::role('Driver')->$condition('created_at',$date??now())->count();

     return compact($variable);
  }

   /**
   * Get Count All New Owners In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_owners($type,$date=null):array
  {
    //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_owners_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = User::role('Owner')->$condition('created_at',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Cars In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_cars($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_cars_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Car::$condition('created_at',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Trips In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_trips($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_trips_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Trip::$condition('created_at',$date??now())->count();

     return compact($variable);
  }

  /**
   * Get Count All New Type Cars In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_typecars($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_typecars_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = TypeCar::$condition('created_at',$date??now())->count();

     return compact($variable);
  }

   /**
   * Get Count All New Booking Seats In This Date | Month | Year
   *
   * @param $type of date
   *
   * @param $date of date can be null if null using now() date
   **/
  public function new_booking_seats($type,$date=null):array
  {
     //check if type correct and in this ['year','month','date']
     $this->check_type_date($type);

     $variable="new_booking_seats_in_".strtolower($type);

     $condition='Where'.ucfirst(strtolower($type));

     $$variable = Seat::$condition('booking_time',$date??now())->count();

     return compact($variable);
  }

   /**
   * Get All Information In Date | Month | Year For Admin
   *
  **/
  public function all_admin_date($type,$date=null):array
  {
      //check if type correct and in this ['year','month','date']
      $this->check_type_date($type);

      return
      $this->new_booking_seats($type,$date) + $this->new_cars($type,$date) +
      $this->new_drivers($type,$date)       + $this->new_owners($type,$date) +
      $this->new_typecars($type,$date)      + $this->new_trips($type,$date) + $this->new_passengers($type,$date);
  }


}
