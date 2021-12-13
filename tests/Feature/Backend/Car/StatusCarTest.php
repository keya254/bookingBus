<?php

namespace Tests\Feature\Backend\Car;

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

class StatusCarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'status-car']);
        Governorate::factory()->create();
        City::factory()->create();
        TypeCar::factory()->create();
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_change_status()
    {
        $this->json('post', '/backend/car/changestatus')
            ->assertUnauthorized();
    }

    public function test_user_not_has_permission_status_car_can_not_change_status()
    {
        $this->actingAs($this->user);
        $this->json('post', '/backend/car/changestatus')
            ->assertForbidden();
    }

    public function test_user_has_permission_status_car_can_change_status_belonge_to_this_user()
    {
        $car = Car::factory()->create();
        $car->owner->givePermissionTo('status-car');
        $this->actingAs($car->owner);
        $this->json('post', '/backend/car/changestatus', ['id' => $car->id])
            ->assertSuccessful();
        $this->assertNotEquals($car->status, $car->fresh()->status);
    }

    public function test_user_has_permission_status_car_can_change_status_not_belonge_to_this_user()
    {
        $car = car::factory()->create();
        $user2 = User::factory()->create();
        $user2->givePermissionTo('status-car');
        $this->actingAs($user2);
        $this->json('post', '/backend/car/changestatus', ['id' => $car->id])
            ->assertForbidden();
        $this->assertEquals($car->status, $car->fresh()->status);
    }
}
