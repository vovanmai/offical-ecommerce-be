<?php

namespace App\Http\Requests\Admin\Post;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
        $id = request()->route('id');

        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('type', Category::TYPE_POST)
            ],
            'status' => 'required|in:1,2',
            'name' => [
                'required',
                'max:100',
                Rule::unique('posts', 'name')->ignore($id)
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
