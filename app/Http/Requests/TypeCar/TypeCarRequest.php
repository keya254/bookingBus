<?php

namespace App\Http\Requests\TypeCar;

use Illuminate\Foundation\Http\FormRequest;

class TypeCarRequest extends FormRequest
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
            'name'=>'required|min:4|max:50',
            'number_seats'=>'required|integer',
            'status'=>'nullable|boolean|in:0,1'
        ];
    }
}
