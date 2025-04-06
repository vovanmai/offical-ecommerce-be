<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

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
            'status' => 'required|in:1,2',
            'name' => [
                'nullable',
                'max:50',
            ],
            'url' => [
                'nullable',
            ],
            'image_id' => [
                'required',
                'integer'
            ],
        ];
    }
}
