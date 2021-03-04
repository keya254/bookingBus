<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table='seats';

    protected $fillable=['name','status','trip_id','passenger_id','booking_time'];

    protected $appends=['booking'];

    protected $casts=['booking_time'=>'dateTime','status'=>'boolean','passenger_id'=>'integer','trip_id'=>'integer','name'=>'string'];

    /**
     * Get the passenger that owns the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function passenger()
    {
        return $this->belongsTo(User::class,'passenger_id');
    }

    /**
     * Get the trip that owns the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function trip()
    {
        return $this->belongsTo(Trip::class,'trip_id');
    }

    /**
    * Check Activation for the Seat
    */
    public function ScopeActive($q)
    {
      return $q->where('status',1);
    }

    /**
    * Check Activation for the Seat
    */
    public function ScopeInactive($q)
    {
     return  $q->where('status',0);
    }

    /**
    * Get date booking_time by diffforhumans
    */
    public function getBookingAttribute()
    {
     return $this->booking_time?$this->booking_time->diffforHumans():null;
    }
}
