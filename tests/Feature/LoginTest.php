<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginTest extends TestCase
{
	use RefreshDatabase;
	/**
	 * A basic test example.
	 */
	public function test_login_view_is_access() {
		$this->view('login')->assertSee("Events - Login");
	}

	public function test_login_route_is_access(): void
	{
		$response = $this->get('/login');
		$response->assertStatus(200);
	}

	public function test_success_authorization() {
		$password = 'test_password';
		$user = $this->createUser($password);

		$response = $this->post('/login', [
			'login' => $user->login,
			'password' => $password
		]);

		$response->assertStatus(200);
		$this->assertAuthenticatedAs($user);
	}

	public function test_fail_authorization() {
		$password = 'test_password';
		$user = $this->createUser($password);

		$response = $this->post('/login', [
			'login' => 'abracadabra',
			'password' => $password
		]);

		$response->assertStatus(403);
		$this->assertGuest();

		$response = $this->post('/login', [
			'login' => $user->login,
			'password' => 'sadfasdf'
		]);

		$response->assertStatus(403);
		$this->assertGuest();
	}

	protected function createUser($password): User {
		return User::create([
			'login' => 'test_login',
			'first_name' => 'test_first_name',
			'last_name' => 'test_last_name',
			'password' => Hash::make($password)
		]);
	}
}
