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
            'from'=>'required',
            'to'=>'required',
            'day'=>'required|date|after_or_equal:'.now(),
            'start_time'=>'required',
            'min_time'=>'required|integer',
            'max_time'=>'required|integer',
            'status'=>'nullable|in:0,1',
            'car_id'=>'required|integer',
            'driver_id'=>'required|integer',
            'price'=>'required|integer',
        ];
    }
}
