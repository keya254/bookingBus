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

class DeleteTripTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        $this->user = User::factory()->create();
        Permission::create(['name'=>'delete-trip']);
        TypeCar::factory()->create();
        Governorate::factory()->create();
        City::factory()->count(2)->create();
        Car::factory()->create();
        $this->trip=Trip::factory()->create();
    }

    public function test_user_not_has_permission_delete_trip()
    {
        //login user has permissions and delete trip  founded and deleted it
        $this->actingAs($this->user)
             ->json('DELETE','/backend/trip/'.$this->trip->id)
             ->assertStatus(403);
    }

    public function test_user_has_permission_delete_trip_and_success_deleted()
    {
        //user has permissions delete_trip
        $this->user->givePermissionTo(['delete-trip']);
        //login user has permissions and delete trip  founded and deleted it
        $this->actingAs($this->user)
             ->json('DELETE','/backend/trip/'.$this->trip->id)
             ->assertStatus(200);
    }

    public function test_user_has_permission_delete_trip_not_found()
    {
        //user has permissions delete_trip
        $this->user->givePermissionTo(['delete-trip']);
        //login user has permissions and delete trip not found
        $this->actingAs($this->user)
             ->json('DELETE','/backend/trip/'.$this->trip->id+6)
             ->assertStatus(404);
    }
}
