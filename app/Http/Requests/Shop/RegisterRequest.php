<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
				'email' => 'required|email:rfc|unique:users,user_email',
				'password' => 'required|min:8',
				'password_confirmation' => 'required|same:password',
		        'regulations' => 'required'
		];
	}
	
	public function attributes(){
	    
	    return [
	        'email' => 'Adres e-mail',
	        'password' => 'Hasło',
	        'password_confirmation' => 'Powtórz hasło',
	        'regulations' => 'Akceptuję warunki Regulaminu'
	    ];
	    
	}
}
