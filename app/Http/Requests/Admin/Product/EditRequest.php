<?php

namespace App\Http\Requests\Admin\Product;

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
            'category_id' => 'required|integer|exists:categories,id',
            'status' => 'required|in:1,2',
            'name' => [
                'required',
                'max:150',
                Rule::unique('products', 'name')->ignore($id),
            ],
            'description' => "nullable",
            'price' => [
                'required',
                'integer',
                'min:1000'
            ],
            'sale_price' => [
                'nullable',
                'integer',
                'min:1000'
            ],
            'preview_image_id' => [
                'required',
                'integer',
            ],
            'detail_file_ids' => [
                'required',
                'array',
            ],
            'inventory_quantity' => [
                'required',
                'integer',
            ],
            'unit' => [
                'required',
                'string',
                'max:50'
            ],
        ];
    }
}
