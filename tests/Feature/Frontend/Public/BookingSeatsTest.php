<?php

namespace Tests\Feature\Frontend\Public;

use App\Models\Car;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Trip;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingSeatsTest extends TestCase
{
   use RefreshDatabase,WithFaker;

   protected function setUp(): void
   {
       parent::setUp();

       User::factory()->create();
       Governorate::factory()->create();
       City::factory(2)->create();
       TypeCar::factory()->create();
       Car::factory()->create();
       $this->trip1=Trip::factory()->create(['max_seats'=>3]);
       $this->trip2=Trip::factory()->create(['max_seats'=>3,'start_trip'=>now()]);
   }

   public function test_booking_seats_in_trip_success_booking()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertSuccessful();
      $this->assertDatabaseCount('passengers',1);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>1]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_max_seats_fail_where_phone_number_unique()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertSuccessful();
      // the same user can not booking where max seats = 3
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'4,5,6'])
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',1);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>1]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_max_seats_fail_where_phone_number_unique_max_user_booking()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2'])
           ->assertSuccessful();
      // the same user can not booking where max seats = 3
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'3,4'])
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',1);
      $this->assertDatabaseHas('seats',['name'=>2,'passenger_id'=>1]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_max_seats_where_phone_number_unique_2_users_can_booking()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertSuccessful();
       // anthor user can booking where max seats = 3
      $this->json('post','/booking',['name'=>'ahmed','phone_number'=>'01289189912','trip_id'=>$this->trip1->id,'myseats'=>'4,5,6'])
           ->assertSuccessful();
      $this->assertDatabaseCount('passengers',2);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>1]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>2]);
   }

   public function test_booking_seats_in_trip_and_start_trip_before_now()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip2->id,'myseats'=>'1,2,3'])
           ->assertNotFound();
   }

   public function test_booking_seats_in_trip_new_passenger_can_not_booking_seats_booked()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertSuccessful();
      $this->json('post','/booking',['name'=>'ahmed','phone_number'=>'01289189914','trip_id'=>$this->trip1->id,'myseats'=>'1'])
           ->assertSuccessful();
      $this->assertDatabaseCount('passengers',2);
      // user booking seat number
      $this->assertDatabaseHas('seats',['name'=>1,'passenger_id'=>1]);
      // new user can not booking the same seat
      $this->assertDatabaseMissing('seats',['name'=>1,'passenger_id'=>2]);
   }


   public function test_booking_seats_in_trip_and_fail_booking_name_required()
   {
      $this->json('post','/booking',['name'=>null,'phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertJsonValidationErrors('name')
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',0);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>null]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_and_fail_booking_name_min_4()
   {
      $this->json('post','/booking',['name'=>'moh','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertJsonValidationErrors('name')
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',0);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>null]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_and_fail_booking_phone_number_required()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>null,'trip_id'=>$this->trip1->id,'myseats'=>'1,2,3'])
           ->assertJsonValidationErrors('phone_number')
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',0);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>null]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_and_fail_booking_trip_id_not_found()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id+3,'myseats'=>'1,2,3'])
           ->assertJsonValidationErrors('trip_id')
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',0);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>null]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }

   public function test_booking_seats_in_trip_and_fail_booking_myseats_required()
   {
      $this->json('post','/booking',['name'=>'mohamed','phone_number'=>'01289189978','trip_id'=>$this->trip1->id,'myseats'=>''])
           ->assertJsonValidationErrors('myseats')
           ->assertStatus(422);
      $this->assertDatabaseCount('passengers',0);
      $this->assertDatabaseHas('seats',['name'=>3,'passenger_id'=>null]);
      $this->assertDatabaseHas('seats',['name'=>4,'passenger_id'=>null]);
   }


}
