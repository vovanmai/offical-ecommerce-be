<?php

namespace App\Http\Requests\Admin\Page;

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
            'status' => 'required|in:1,2',
            'name' => [
                'required',
                'max:50',
                Rule::unique('pages', 'name')->ignore($id),
            ],
            'description' => [
                'required',
            ],
            'is_display_main_menu' => 'nullable|boolean',
            'is_display_footer' => 'nullable|boolean',
        ];
    }
}
