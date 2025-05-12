<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateRequest extends FormRequest
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
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'status' => 'required|in:1,2',
            'name' => [
                'required',
                'max:100',
                Rule::unique('posts', 'name')
            ],
            'short_description' => [
                'required',
                'max:255',
            ],
            'description' => [
                'required',
            ],
            'preview_image_id' => [
                'required',
                'integer',
            ]
        ];
    }
}
