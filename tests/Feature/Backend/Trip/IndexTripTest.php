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
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexTripTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'trips']);
        $this->user = User::factory()->create();
        TypeCar::factory()->create();
        Governorate::factory()->create();
        City::factory()->count(2)->create();
    }

    public function test_guest_can_not_see_page()
    {
        //guest visit page
        $this->get('/backend/trip')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_trips_can_not_see_page()
    {
        //login user visit page
        $this->actingAs($this->user)
             ->get('/backend/trip')
             ->assertStatus(403);
    }

    public function test_user_have_permission_trips_can_see_page()
    {
        Car::factory()->count(10)->create();
        Role::create(['name'=>'Driver']);
        Trip::factory()->count(10)->create();
        //give permission trips to user to see page
        $this->user->givePermissionTo('trips');
         //login user visit page
        $this->actingAs($this->user)
             ->get('/backend/trip')
             ->assertStatus(200)
             ->assertViewIs('backend.trip.index')
             ->assertViewHasAll(['cars','drivers','governorates'])
             ->assertSee(['الرحلات']);
        $this->assertDatabaseCount('trips',10);
    }
}
