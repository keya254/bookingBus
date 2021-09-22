<?php

namespace Tests\Feature\Frontend\Private;

use App\Models\Car;
use App\Models\CarCities;
use App\Models\City;
use App\Models\Governorate;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrivateTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Governorate::factory()->create();
        $this->city=City::factory()->create();
        User::factory()->create();
        TypeCar::factory()->create();
    }


    public function test_private_page_can_load_car_status_1_car_private_1()
    {
        $car=Car::factory()->create(['status'=>1,'private'=>1]);
        CarCities::create(['car_id'=>$car->id,'city_id'=>$this->city->id]);
        $this->get('/private')
        ->assertViewHasAll(['cars','governorates'])
        ->assertSee($car->owner->name);
    }

    public function test_private_page_can_load_car_status_0_car_private_1()
    {
        $car=Car::factory()->create(['status'=>0,'private'=>1]);
        CarCities::create(['car_id'=>$car->id,'city_id'=>$this->city->id]);
        $this->get('/private')
        ->assertViewHasAll(['cars','governorates'])
        ->assertSee(['لا يوجد سيارات متاحة لهذا الطريق الان']);
    }

    public function test_private_page_can_load_car_status_1_car_private_0()
    {
        $car=Car::factory()->create(['status'=>1,'private'=>0]);
        CarCities::create(['car_id'=>$car->id,'city_id'=>$this->city->id]);
        $this->get('/private')
        ->assertViewHasAll(['cars','governorates'])
        ->assertSee(['لا يوجد سيارات متاحة لهذا الطريق الان']);
    }

}
