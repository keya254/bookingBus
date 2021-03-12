<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image'=>'images/cars/1.png',
            'name'=>$this->faker->name,
            'status'=>$this->faker->randomElement([0,1]),
            'owner_id'=>User::all()->random()->id,
            'typecar_id'=>TypeCar::all()->random()->id,
            'phone_number'=>$this->faker->randomElement(['010','011','012','015']).rand(00000000,99999999),
            'private'=>$this->faker->randomElement([0,1]),
            'public'=>$this->faker->randomElement([0,1])
        ];
    }
}
