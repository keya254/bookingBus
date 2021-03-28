<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
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
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'=>'required|min:3',
            'status'=>'nullable|boolean|in:0,1',
            'typecar_id'=>'required|integer|exists:type_cars,id',
            'private'=>'nullable|boolean|in:0,1',
            'public'=>'nullable|boolean|in:0,1',
            'phone_number'=>'required|size:11',
        ];
    }
}
