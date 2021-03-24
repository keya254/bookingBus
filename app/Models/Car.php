<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table='cars';

    protected $fillable=['image','name','status','owner_id','typecar_id','private','public','phone_number'];

    protected $appends=['image_path'];


    /**
     * Get the owner that owns the Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the typecar that owns the Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typecar()
    {
        return $this->belongsTo(TypeCar::class, 'typecar_id');
    }

    /**
     * Get all of the trips for the Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class,'car_id');
    }

    /**
     * Get all of the cities for the Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function cities()
    {
        return $this->belongsToMany(City::class,'car_city');
    }

    /**
    * Check Activation for the Car
    */
    public function ScopeActive($q)
    {
        return  $q->where('status',1);
    }

    /**
    * Check Activation for the Car
    */
    public function ScopeInactive($q)
    {
        return  $q->where('status',0);
    }

    /**
    * Check Car Can Work Public
    */
    public function ScopePublic($q)
    {
        return  $q->where('public',1);
    }

    /**
    * Check Car Can Not Work Public
    */
    public function ScopeNotpublic($q)
    {
        return  $q->where('public',0);
    }

    /**
    * Check Car Can Work Private
    */
    public function ScopePrivate($q)
    {
        return $q->where('private',1);
    }

    /**
    * Check Car Can Not Work Private
    */
    public function ScopeNotPrivate($q)
    {
        return  $q->where('private',0);
    }

    /**
    * Check Car Can Work Only Private
    */
    public function ScopeOnlyPrivate($q)
    {
        return $q->private()->notpublic();
    }

    /**
    * Check Car Can Work Only Public
    */
    public function ScopeOnlyPublic($q)
    {
        return  $q->notprivate()->public();
    }

    /**
    * Check Car Can Work Both Public And Private
    */
    public function ScopeWorkBoth($q)
    {
        return $q->private()->public();
    }

    /**
    * Get Image Path For Car
    */
    public function getImagePathAttribute()
    {
        return asset($this->image);
    }
}
