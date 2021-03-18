<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Image;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the cars for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(Car::class,'owner_id');
    }

    /**
     * Get all of the seats for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seats()
    {
        return $this->hasMany(Seat::class, 'passenger_id');
    }

    /**
     * Get all of the trips for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    /**
     * Get all of the drivers for the Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drivers()
    {
        return $this->hasMany(OwnerDriver::class,'owner_id');
    }

    /**
     * Get the owner that owns the driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(OwnerDriver::class,'driver_id');
    }

    public static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if(is_file($model->image)){
            $name='images/users/'.time().rand(11111,99999).'.png';
            Image::make($model->image)->resize(500, 500)->save($name);
            $model->image =$name;
            }
        });
    }
}
