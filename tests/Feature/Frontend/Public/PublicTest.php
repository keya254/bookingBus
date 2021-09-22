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

class PublicTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Governorate::factory()->create();
        $this->city1=City::factory()->create();
        $this->city2=City::factory()->create();
        User::factory()->create();
        TypeCar::factory()->create();
        $this->car1=Car::factory()->create();
        $this->car2=Car::factory()->create();
    }

    public function test_search_page_with_trips_two_active()
    {
        $this->withoutExceptionHandling();
        $this->trip1=Trip::factory()->create(['to_id'=>$this->city1->id,'from_id'=>$this->city2->id,'status'=>1,'start_trip'=>now()->addDay(1)]);
        $this->trip2=Trip::factory()->create(['to_id'=>$this->city2->id,'from_id'=>$this->city1->id,'status'=>1,'start_trip'=>now()->addDay(2)]);
        $this->get('/search')
             ->assertSee($this->trip1->day_trip)
             ->assertSee($this->trip2->day_trip);
    }

    public function test_search_page_with_trips_one_active_one_inactive()
    {
        $this->trip1=Trip::factory()->create(['to_id'=>$this->city1->id,'from_id'=>$this->city2->id,'status'=>1,'start_trip'=>now()->addDay(1)]);
        $this->trip2=Trip::factory()->create(['to_id'=>$this->city2->id,'from_id'=>$this->city1->id,'status'=>0,'start_trip'=>now()->addDay(2)]);
        $this->get('/search')
             ->assertSee($this->trip1->day_trip)
             ->assertDontSee($this->trip2->day_trip);
    }

    public function test_search_page_without_trips()
    {
        $this->get('/search')
             ->assertSee(['لا يوجد رحلات من هذا الطريق'])
             ->assertViewHasAll(['governorates','trips']);
    }
}
