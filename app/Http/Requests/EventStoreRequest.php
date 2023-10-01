<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	protected function prepareForValidation(): void {
		$this->merge([
			'creator_id' => $this->user()->id
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'title' => 'required|max:255|unique:events',
			'description' => 'required',
			'creator_id' => 'required|numeric'
		];
	}

	public function messages(): array {
		return [
			'title.required' => 'Остутствует заголовок',
			'title.max' => 'Превышена длина заголовка',
			'title.unique' => 'Событие с таким заголовком уже существует',
			'description.required' => 'Остутствует описание'
		];
	}
}
