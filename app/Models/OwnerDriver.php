<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerDriver extends Model
{
    use HasFactory;

    protected $table='owner_driver';

    protected $fillable=['owner_id','driver_id'];

    protected $appends=[];
}
