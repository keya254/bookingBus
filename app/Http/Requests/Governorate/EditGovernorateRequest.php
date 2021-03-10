<?php

namespace App\Http\Requests\Governorate;

use Illuminate\Foundation\Http\FormRequest;

class EditGovernorateRequest extends FormRequest
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
            'name'=>'required|unique:governorates,name,'.request()->route('governorate')->id,
        ];
    }
}
