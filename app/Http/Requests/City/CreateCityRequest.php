<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class CreateCityRequest extends FormRequest
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
            'governorate_id'=>'required|numeric|exists:governorates,id',
            'name'=>'min:3|required|unique:cities,name,null,id,governorate_id,'.request('governorate_id'),
        ];
    }
}
