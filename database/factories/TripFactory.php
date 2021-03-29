<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\City;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from_id'=>City::all()->random()->id,
            'to_id'=>City::all()->random()->id,
            'day'=>now()->addDay(rand(1,9)),
            'start_time'=>now()->addMinutes(rand(4,300)),
            'min_time'=>122,
            'max_time'=>124,
            'max_seats'=>rand(1,6),
            'price'=>rand(10,500),
            'status'=>$this->faker->randomElement([0,1]),
            'car_id'=>Car::all()->random()->id,
            'driver_id'=>User::all()->random()->id,
        ];
    }
}
