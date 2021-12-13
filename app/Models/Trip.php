<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';

    protected $fillable = ['from_id', 'to_id', 'start_trip', 'min_time', 'max_time', 'price', 'status', 'car_id', 'driver_id', 'max_seats'];

    protected $appends = ['day_trip', 'time_trip'];

    protected $casts = ['status' => 'boolean', 'min_time' => 'integer', 'max_time' => 'integer', 'price' => 'float'];

    protected $dates = ['start_trip'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            for ($i = 1; $i <= $model->car->typeCar->number_seats; $i++) {
                $model->seats()->create(['name' => $i]);
            }
        });
    }
    /**
     * Get the to that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(City::class, 'to_id', 'id');
    }

    /**
     * Get the from that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(City::class, 'from_id', 'id');
    }

    /**
     * Get the driver that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get all of the seats for the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Check Activation for the Trip
     */
    public function ScopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }

    /**
     * Check Activation for the Trip
     */
    public function ScopeInactive(Builder $query)
    {
        return $query->where('status', 0);
    }

    /**
     * Get Trip Before Now
     */
    public function ScopeBeforeNow(Builder $query)
    {
        return $query->where('start_trip', '>', now());
    }

    /**
     * Get Trip Before Now
     */
    public function ScopeAfterNow(Builder $query)
    {
        return $query->where('start_trip', '<', now());
    }

    /**
     * Get Trip In Date Format
     */
    public function getDayTripAttribute()
    {
        return $this->start_trip->format('Y-m-d');
    }

    /**
     * Get Trip In Time Format
     */
    public function getTimeTripAttribute()
    {
        return $this->start_trip->format('h:i A');
    }
}
