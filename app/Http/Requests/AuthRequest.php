<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends CustomFormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'login' => 'required',
			'password' => 'required',
		];
	}

	public function attributes(): array {
		return [
			'login' => 'Логин',
			'password' => 'Пароль'
		];
	}

	public function messages(): array {
		return [
			'required' => ':attribute - обязательное поле для заполнения',
		];
	}
}
