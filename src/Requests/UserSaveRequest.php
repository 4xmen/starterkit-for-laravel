<?php

namespace Xmen\StarterKit\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UserSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() and auth()->user()->hasRole('super-admin|manager');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd($this);
        return [
            //
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,".$this->id],
            'password' => ['string', 'min:8', 'confirmed','nullable'],
        ];
    }
}
