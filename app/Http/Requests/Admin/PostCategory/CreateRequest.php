<?php

namespace App\Http\Requests\Admin\PostCategory;

use App\Models\Category;
use App\Rules\CheckExistedCategoryName;
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
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', Category::TYPE_POST);
                }),
            ],
            'status' => [
                'required',
                Rule::in(Category::STATUS_ACTIVE, Category::STATUS_INACTIVE),
            ],
            'name' => [
                'required',
                'max:50',
                new CheckExistedCategoryName($this->get('parent_id'), Category::TYPE_POST),
            ],
            'description' => "nullable",
            'is_display_main_menu' => 'nullable|boolean',
            'is_display_footer' => 'nullable|boolean',
        ];
    }
}
