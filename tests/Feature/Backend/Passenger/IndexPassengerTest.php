<?php

namespace Tests\Feature\Backend\Passenger;

use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Setting;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexPassengerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'passengers']);
        Role::create(['name'=>'Owner']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_passenger_page()
    {
        $this->get('/backend/passenger')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_passegners_can_not_see_passenger_page()
    {
        $this->actingAs($this->user)
             ->get('/backend/passenger')
             ->assertForbidden();
    }

    public function test_user_have_permission_passegners_can_see_passenger_page()
    {
        $this->user->givePermissionTo('passengers');
        $this->actingAs($this->user)
             ->get('/backend/passenger')
             ->assertSee('العملاء')
             ->assertSuccessful();
    }

    public function test_user_have_permission_passegners_can_see_passengers_only_in_user_trips_with_role_owner()
    {
        $trip1=Trip::factory()->create();
        $trip2=Trip::factory()->create();
        $passenger1=Passenger::create(['name'=>'mohamed','phone_number'=>'01234567887']);
        $passenger2=Passenger::create(['name'=>'ahmed','phone_number'=>'01000067887']);
        $seat1=Seat::where('trip_id',$trip1->id)->where('name','1')->first();
        $seat1->update(['passenger_id'=>$passenger1->id]);
        $seat2=Seat::where('trip_id',$trip2->id)->where('name','1')->first();
        $seat2->update(['passenger_id'=>$passenger2->id]);
        $trip1->car->owner->assignRole('Owner');
        $trip1->car->owner->givePermissionTo('passengers');
        $this->actingAs($trip1->car->owner)
             ->get('/backend/passenger', array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
             ->assertSee('mohamed')
             ->assertSuccessful();
    }

    public function test_user_have_permission_passegners_can_not_see_passengers_in_another_user_trips_with_role_owner()
    {
        $trip1=Trip::factory()->create();
        $trip2=Trip::factory()->create();
        $passenger1=Passenger::create(['name'=>'mohamed','phone_number'=>'01234567887']);
        $passenger2=Passenger::create(['name'=>'ahmed','phone_number'=>'01000067887']);
        $seat1=Seat::where('trip_id',$trip1->id)->where('name','1')->first();
        $seat1->update(['passenger_id'=>$passenger1->id]);
        $seat2=Seat::where('trip_id',$trip2->id)->where('name','1')->first();
        $seat2->update(['passenger_id'=>$passenger2->id]);
        $trip1->car->owner->assignRole('Owner');
        $trip1->car->owner->givePermissionTo('passengers');
        $this->actingAs($trip1->car->owner)
             ->get('/backend/passenger', array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
             ->assertDontSee('ahmed')
             ->assertSuccessful();
    }
}
