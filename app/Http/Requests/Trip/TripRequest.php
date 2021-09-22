<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'from_id'=>'required|exists:cities,id',
            'to_id'=>'required|exists:cities,id|different:from_id',
            'start_trip'=>'required|after_or_equal:'.now(),
            'min_time'=>'required|integer|lt:max_time',
            'max_time'=>'required|integer',
            'status'=>'nullable|in:0,1',
            'car_id'=>'required|integer|exists:cars,id',
            'driver_id'=>'required|integer|exists:users,id',
            'price'=>'required|integer',
            'max_seats'=>'required|integer',
        ];
    }
}
