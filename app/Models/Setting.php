<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Image;


class Setting extends Model
{
    use HasFactory;

    protected $table='settings';

    protected $fillable=['name','description','logo','facebook','youtube','twitter','instagram'];

    public static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if(is_file($model->logo)){
            Image::make($model->logo)->resize(500, 500)->save('images/logo/logo.png');
            $model->logo ='images/logo/logo.png';
            }
        });
    }
}
