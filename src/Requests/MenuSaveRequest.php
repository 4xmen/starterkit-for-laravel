<?php

namespace Xmen\StarterKit\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuSaveRequest extends FormRequest
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
            'name' => ['required', 'string', 'alpha_num', 'max:255', 'min:3'],
        ];
    }
}
