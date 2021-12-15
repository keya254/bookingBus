<?php

namespace App\Traits;

use App\Models\Car;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\TypeCar;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait Admin
{
  /**
   * Get Count All Roles
   *
   **/
  public function roles():array
  {
     $roles = Role::where('name','!=','SuperAdmin')->count();

     return compact('roles');
  }

  /**
   * Get Count All Permissions
   *
   **/
  public function permissions():array
  {
    $permissions = Permission::count();

    return compact('permissions');
  }

  /**
   * Get Count All Governorates
   *
   **/
  public function governorates():array
  {
     $governorates = Governorate::count();

     return compact('governorates');
  }

  /**
   * Get Count All Cities
   *
   **/
  public function cities():array
  {
     $cities = City::count();

     return compact('cities');
  }

  /**
   * Get Count All Passengers
   *
   **/
  public function passengers():array
  {
     $passengers = Passenger::count();

     return compact('passengers');
  }

  /**
   * Get Count All Drivers
   *
   **/
  public function drivers():array
  {
      $drivers = User::role('Driver')->count();

      return compact('drivers');
  }

  /**
   * Get Count All Owners
   *
   **/
  public function owners():array
  {
      $owners= User::role('Owner')->count();

      return compact('owners');
  }

  /**
   * Get Count All Trips
   *
   **/
  public function trips():array
  {
     $trips           = Trip::count();
     $active_trips    = Trip::active()->count();
     $inactive_trips  = Trip::inactive()->count();

     return compact('trips' , 'active_trips' , 'inactive_trips');
  }

  /**
   * Get Count All Cars
   *
   **/
  public function cars():array
  {
    $cars           = Car::count();
    $active_cars    = Car::active()->count();
    $inactive_cars  = Car::inactive()->count();

    return compact('cars' , 'active_cars' , 'inactive_cars');
  }

  /**
   * Get Count All Type Cars
   *
   **/
  public function type_cars():array
  {
    $type_cars           = TypeCar::count();
    $active_type_cars    = TypeCar::active()->count();
    $inactive_type_cars  = TypeCar::inactive()->count();

    return compact('type_cars' , 'active_type_cars' , 'inactive_type_cars');
  }

   /**
   * Get Count All Seats
   *
   **/
  public function seats():array
  {
    $seats           = Seat::count();
    $active_seats    = Seat::active()->count();
    $inactive_seats  = Seat::inactive()->count();

    return compact('seats' , 'active_seats' , 'inactive_seats');
  }

  /**
   * Get All Information To Admin
   *
   **/
  public function admin_all():array
  {
      return
      $this->roles()    + $this->permissions() +
      $this->governorates() + $this->cities() +
      $this->type_cars() + $this->cars()     +
      $this->trips()    + $this->seats()    +
      $this->owners()   + $this->drivers()  + $this->passengers();
  }
}
