<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Category;
use App\Rules\CheckExistedCategoryName;
use Illuminate\Foundation\Http\FormRequest;

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
            'parent_id' => 'nullable|integer|exists:categories,id',
            'status' => 'required|in:1,2',
            'name' => [
                'required',
                'max:50',
                new CheckExistedCategoryName($this->get('parent_id'), Category::TYPE_PRODUCT),
            ],
            'description' => "nullable",
            'is_display_main_menu' => 'nullable|boolean',
            'is_display_footer' => 'nullable|boolean',
        ];
    }
}
