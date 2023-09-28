<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function notAuth($response){

	}

	protected function notFoundWithMessage($response, $message='Запрашиваемый ресурс не найден') {
		// code...
	}

	protected function errWithMessage($response, $message) {
		// code...
	}
}
