<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class CallMeRequest extends FormRequest
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
				'phone' => 'required',
				'verify' => 'required|in:5',
		];
	}
	
	public function attributes(){
	    
	    return [
	        'name' => 'Imię',
	        'phone' => 'Telefon',
	        'verify' => 'Wynik działania',
	    ];
	    
	}
}
