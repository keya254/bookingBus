<?php

namespace Database\Factories;

use App\Models\TypeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeCarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeCar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'number_seats'=>$this->faker->randomElement([7,11,43]),
            'status'=>$this->faker->randomElement([0,1])
        ];
    }
}
