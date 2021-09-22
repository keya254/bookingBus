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

class PublicCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'public-car']);
        Governorate::factory()->create();
        City::factory()->create();
        TypeCar::factory()->create();
        $this->user=User::factory()->create();
    }

    public function test_guest_can_not_change_public()
    {
        $this->json('post','/backend/car/changepublic')
             ->assertUnauthorized();
    }

    public function test_user_not_has_permission_public_car_can_not_change_public()
    {
        $this->actingAs($this->user);
        $this->json('post','/backend/car/changepublic')
             ->assertForbidden();
    }

    public function test_user_has_permission_public_car_can_change_public_belonge_to_this_user()
    {
        $car=Car::factory()->create();
        $car->owner->givePermissionTo('public-car');
        $this->actingAs($car->owner);
        $this->json('post','/backend/car/changepublic',['id'=>$car->id])
             ->assertSuccessful();
        $this->assertNotEquals($car->public,$car->fresh()->public);
    }

    public function test_user_has_permission_public_car_can_change_public_not_belonge_to_this_user()
    {
        $car=Car::factory()->create();
        $user2=User::factory()->create();
        $user2->givePermissionTo('public-car');
        $this->actingAs($user2);
        $this->json('post','/backend/car/changepublic',['id'=>$car->id])
             ->assertForbidden();
        $this->assertEquals($car->public,$car->fresh()->public);
    }
}
