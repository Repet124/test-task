<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;

class CustomValidationException extends ValidationException {

	protected static function summarize($validator) {
		return "Ошибка валидации данных";
	}
}
