<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends CustomFormRequest
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
			'login' => 'required|unique:users|max:20|min:2',
			'password' => 'required|min:8',
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
		];
	}

	public function attributes(): array {
		return [
			'login' => 'Логин',
			'password' => 'Пароль',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия'
		];
	}

	public function messages(): array {
		return [
			'required' => ':attribute - обязательное поле для заполнения',
			'login.unique' => 'Пользователь с данным логином уже существует',
			'login.max' => 'Логин слишком длинный',
			'login.min' => 'Логин должен быть не меньше 2-ух символов',
			'password.min' => 'Пароль должен быть не менее 8 символов',
		];
	}
}
