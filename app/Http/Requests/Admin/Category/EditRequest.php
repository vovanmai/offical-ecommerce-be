<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckExistedCategoryName;

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
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'name' => [
                'required',
                'max:50',
                // new CheckExistedCategoryName($this->get('category_id'), Category::TYPE_PRODUCT),
            ],
            'description' => "nullable",
        ];
    }
}
