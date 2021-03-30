<?php

namespace Tests\Feature\Backend\Trip;

use App\Models\Car;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;


class CreateTripTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-trip']);
        $this->user = User::factory()->create();
        TypeCar::factory()->create();
        Governorate::factory()->create();
        City::factory()->count(3)->create();
        Car::factory()->count(2)->create();
    }

    public function test_user_not_have_permission_create_trip()
    {
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip')
             ->assertStatus(403);
    }

    public function test_user_have_permission_create_trip_suucess_created()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertStatus(200)
             ->assertSee('success created');
        //check the database table trips have a record
        $this->assertDatabaseCount('trips',1);
    }

    public function test_user_have_permission_create_trip_and_from_id_equal_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => null , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['from_id'])
             ->assertStatus(422);
        //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_from_id_not_exist_in_database()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 4 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['from_id'])
             ->assertStatus(422);
        //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);

    }

    public function test_user_have_permission_create_trip_and_to_id_equal_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => null, 'start_trip' => now(), 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['to_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);

    }

    public function test_user_have_permission_create_trip_and_to_id_not_exist_in_database()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 4,'start_trip' => now() , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['to_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);

    }

    public function test_user_have_permission_create_trip_and_to_id_equal_from_id()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 1, 'start_trip' => now() , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['to_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_start_trip_equal_before_to_start_trip()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now()->addDay(-1) , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['start_trip'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_start_trip_not_date_only()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2,'start_trip' => now()->format('Y-m-d') , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['start_trip'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_start_trip_not_time_only()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now()->format('h:i a') , 'min_time' => 44, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['start_trip'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_min_time_not_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 'ui', 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['min_time'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_min_time_required()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2,'start_trip' => now() , 'min_time' => null, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['min_time'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_min_time_more_than_max_time()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 74, 'max_time' => 66 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['min_time'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_max_time_required()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2,'start_trip' => now(), 'min_time' => 56, 'max_time' => null ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['min_time','max_time'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_max_time_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => "jg" ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['min_time','max_time'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_status_in_0_1()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 2,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['status'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_car_id_not_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now()
             , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => null ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['car_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_car_id_not_exist_in_database()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now()  ,
              'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 4 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['car_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_car_id_must_be_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2,
              'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => "frty" ,'driver_id' => 1, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['car_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_driver_id_not_be_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => null, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['driver_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_driver_id_must_be_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => "rf", 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['driver_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_driver_id_not_exists_in_database()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 7, 'max_seats' => 3 , 'price' => 45])
             ->assertJsonValidationErrors(['driver_id'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_max_seats_not_be_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => null , 'price' => 45])
             ->assertJsonValidationErrors(['max_seats'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_max_seats_must_be_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now(), 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => "g" , 'price' => 45])
             ->assertJsonValidationErrors(['max_seats'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_price_not_be_null()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 3 , 'price' => null])
             ->assertJsonValidationErrors(['price'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

    public function test_user_have_permission_create_trip_and_price_must_be_integer()
    {
        //give permission to user create-trip
        $this->user->givePermissionTo('create-trip');
        //login user visit page
        $this->actingAs($this->user)
             ->json('POST','/backend/trip',
             ['from_id' => 1 , 'to_id' => 2, 'start_trip' => now() , 'min_time' => 56, 'max_time' => 88 ,'status' => 1,
              'car_id' => 1 ,'driver_id' => 1, 'max_seats' => 5 , 'price' => "jh"])
             ->assertJsonValidationErrors(['price'])
             ->assertStatus(422);
                     //check the database table trips not have a record
        $this->assertDatabaseCount('trips',0);
    }

}
