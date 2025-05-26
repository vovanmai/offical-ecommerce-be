<?php

namespace App\Http\Requests\Admin\PostCategory;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckExistedCategoryName;
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
            'name' => [
                'required',
                'max:50',
                new CheckExistedCategoryName($this->get('parent_id'), Category::TYPE_POST, $id),
            ],
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
            'description' => "nullable",
            'is_display_main_menu' => 'nullable|boolean',
            'is_display_footer' => 'nullable|boolean',
        ];
    }
}
