<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;


	protected function getTestUser() {
		return User::where('login', 'test_login')->first();
	}

	protected function assertsNotAuth($response){
		$response->assertStatus(401);
		$response->assertJson([
			'message' => 'Пользователь не авторизован'
		]);
	}

	protected function assertsNotFoundWithMessage($response, $message='Запрашиваемый ресурс не найден') {
		$response->assertStatus(404);
		$response->assertJson([
			'message' => $message
		]);
	}
}
