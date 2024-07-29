<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminPasswordRequest extends FormRequest
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
            'password' => [
                    'nullable',
            		'confirmed',
            		Password::min(8)
            		->mixedCase()
            		->numbers()
            		->symbols()
            		->uncompromised()
            ],
            'user_display_name' => [
                'required'                
            ]
        ];
    }
}
