<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCities extends Model
{
    use HasFactory;

    protected $table = 'car_city';

    protected $fillable = ['car_id', 'city_id'];

    /**
     * Get the car that owns the CarCities
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the city that owns the CarCities
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
