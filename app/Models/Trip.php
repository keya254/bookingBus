<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table='trips';

    protected $fillable=['from_id','to_id','day','start_time','min_time','max_time','price','status','car_id','driver_id','max_seats'];

    protected $appends=['dayformat','timeformat'];

    protected $casts=['day'=>'date:Y-m-d','start_time'=>'date:h:i','status'=>'boolean','min_time'=>'integer','max_time'=>'integer','price'=>'float'];


    /**
     * Get the to that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(City::class,'to_id','id');
    }

    /**
     * Get the from that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(City::class,'from_id','id');
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
    public function ScopeActive($q)
    {
        return $q->where('status',1);
    }

    /**
    * Check Activation for the Trip
    */
    public function ScopeInactive($q)
    {
        return  $q->where('status',0);
    }

    public function getDayformatAttribute()
    {
       return $this->day->format('Y-m-d');
    }

    public function getTimeformatAttribute()
    {
       return $this->start_time->format('h:i A');
    }
}
