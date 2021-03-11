<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'to_id'=>'required|exists:cities,id|different:from_id',
            'from_id'=>'required|exists:cities,id|different:to_id',
            'day'=>'required|date|after_or_equal:'.now()
        ];
    }
}
