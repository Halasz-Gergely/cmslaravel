<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:tags'
        ];
    }
}
