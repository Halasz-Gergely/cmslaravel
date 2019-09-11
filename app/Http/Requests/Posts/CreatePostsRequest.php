<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required|unique:posts',
            'description'   => 'required',
            'image'         => 'required|image',
            'category'      => 'required',
            'postContent'   => 'required',
            'published_at'  => 'required'
        ];
    }
}
