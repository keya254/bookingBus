<?php

namespace App\Http\Requests\CarCities;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarCities extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id'=>'required|exists:cities,id|unique:car_city,city_id,null,id,city_id,'.request('city_id').',car_id,'.request('car_id'),
            'car_id'=>'required|exists:cars,id',
        ];
    }
}
