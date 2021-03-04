<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCar extends Model
{
    use HasFactory;

    protected $table='type_cars';

    protected $fillable=['name','number_seats','status'];

    protected $appends=[];

    protected $casts=['status'=>'boolean','number_seats'=>'integer','name'=>'string'];

    /**
     * Get all of the cars for the TypeCar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
    * Check Activation for the TypeCar
    */
    public function ScopeActive($q)
    {
      return $q->where('status',1);
    }

    /**
    * Check Activation for the TypeCar
    */
    public function ScopeInactive($q)
    {
      return  $q->where('status',0);
    }

}
