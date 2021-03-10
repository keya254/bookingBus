<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class EditCityRequest extends FormRequest
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
            'name'=>'required|unique:cities,name,'.request()->route('city')->id.',id,governorate_id,'.request('governorate_id'),
            'governorate_id'=>'required',
        ];
    }
}
