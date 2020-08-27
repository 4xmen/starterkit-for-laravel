<?php

namespace Xmen\StarterKit\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorySaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', 'string', 'min:5', 'max:128'],
            'description' => ['nullable', 'string', 'min:5'],
            'store_category_id' => ['nullable', 'exists:store_categories,id']
        ];
    }
}
