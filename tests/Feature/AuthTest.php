<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	protected $userData = [
		'login' => 'test_login',
		'first_name' => 'test_first_name',
		'last_name' => 'test_last_name',
		'password' => 'test_password',
	];

	// login tests

	public function test_login_view_is_access() {
		$this->view('login')->assertSee("Events - Login");
	}

	public function test_login_route_is_access(): void
	{
		$response = $this->get('/login');
		$response->assertStatus(200);
	}

	public function test_success_authorization() {
		$user = $this->createUser();

		$response = $this->post('/login', [
			'login' => $user->login,
			'password' => $this->userData['password']
		]);

		$response->assertStatus(200);
		$this->assertAuthenticatedAs($user);
	}

	public function test_fail_authorization() {
		$user = $this->createUser();

		$response = $this->post('/login', [
			'login' => 'abracadabra',
			'password' => $this->userData['password']
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

	//registration tests

	public function test_user_create_view() {
		$this->view('register')->assertSee('Events - Registration');
	}

	public function test_register_route_is_access() {
		$response = $this->get('/register');
		$response->assertStatus(200);
	}

	public function test_success_user_create() {

		$response = $this->post('/register', $this->userData);

		$response->assertRedirect('/login');

		$user = User::where('login', $this->userData['login'])->first();

		$this->assertEquals($user->login, $this->userData['login']);
		$this->assertEquals($user->first_name, $this->userData['first_name']);
		$this->assertEquals($user->last_name, $this->userData['last_name']);
		$this->assertTrue(Hash::check($this->userData['password'],$user->password));

	}

	protected function createUser(): User {
		return User::create([
			'login' => $this->userData['login'],
			'first_name' => $this->userData['first_name'],
			'last_name' => $this->userData['last_name'],
			'password' => $this->userData['password']
		]);
	}
}
