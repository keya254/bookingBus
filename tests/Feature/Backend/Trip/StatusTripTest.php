<?php

namespace Tests\Feature\Backend\Trip;

use App\Models\Car;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Setting;
use App\Models\Trip;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class StatusTripTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'status-trip']);
        Governorate::factory()->create();
        City::factory()->create();
        TypeCar::factory()->create();
        $this->user=User::factory()->create();
        Car::factory()->create();
    }

    public function test_guest_can_not_change_status()
    {
        $this->json('post','/backend/trip/changestatus')
             ->assertUnauthorized();
    }

    public function test_user_not_has_permission_status_trip_can_not_change_status()
    {
        $this->actingAs($this->user);
        $this->json('post','/backend/trip/changestatus')
             ->assertForbidden();
    }

    public function test_user_has_permission_status_trip_can_change_status_belonge_to_this_user()
    {
        $trip=Trip::factory()->create();
        $trip->car->owner->givePermissionTo('status-trip');
        $this->actingAs($trip->car->owner);
        $this->json('post','/backend/trip/changestatus',['id'=>$trip->id])
             ->assertSuccessful();
        $this->assertNotEquals($trip->status,$trip->fresh()->status);
    }

    public function test_user_has_permission_status_trip_can_change_status_not_belonge_to_this_user()
    {
        $trip=Trip::factory()->create();
        $user2=User::factory()->create();
        $user2->givePermissionTo('status-trip');
        $this->actingAs($user2);
        $this->json('post','/backend/trip/changestatus',['id'=>$trip->id])
             ->assertForbidden();
        $this->assertEquals($trip->status,$trip->fresh()->status);
    }
}
