<?php

namespace Tests\Feature\Backend\Car;

use App\Models\Car;
use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeleteCarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'delete-car']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_delete_car()
    {
        //create type car and car
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //login user
        $this->actingAs($this->user)
            ->json('DELETE', '/backend/car/' . $car->id)
            ->assertStatus(403);
    }

    public function test_user_has_permission_delete_car()
    {
        //give user permission delete-car
        $this->user->givePermissionTo('delete-car');
        //create type car and car
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //login user
        $this->actingAs($this->user)
            ->json('DELETE', '/backend/car/' . $car->id)
            ->assertStatus(200);
        $this->assertDatabaseMissing('cars', $car->toArray());
    }

    public function test_user_has_permission_delete_car_fail()
    {
        //give user permission delete-car
        $this->user->givePermissionTo('delete-car');
        //create type car and car
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //login user
        $this->actingAs($this->user)
            ->json('DELETE', '/backend/car/' . $car->id + 1)
            ->assertStatus(404);
        $this->assertDatabaseHas('cars', ['id' => $car->id]);
    }

}
