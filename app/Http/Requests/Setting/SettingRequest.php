<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name'=>'required|min:3',
            'description'=>'required|min:3|max:100',
            'logo'=>'nullable|image',
            'facebook'=>'nullable|url',
            'twitter'=>'nullable|url',
            'instagram'=>'nullable|url',
            'youtube'=>'nullable|url'
        ];
    }
}
