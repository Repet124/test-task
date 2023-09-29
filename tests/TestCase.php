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

	protected function notAuth($response){
		$response->assertStatus(403);
		$response->assertJson([
			'error' => 'Пользователь не авторизован'
		]);
	}

	protected function notFoundWithMessage($response, $message='Запрашиваемый ресурс не найден') {
		$response->assertStatus(404);
		$response->assertJson([
			'error' => $message
		]);
	}

	protected function errWithMessage($response, $message) {
		$response->assertOk();
		$response->assertJson([
			'error' => $message
		]);
	}
}
