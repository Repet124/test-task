<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	protected $seed = true;
	protected $seeder = TestingSeeder::class;

	// login tests

	public function test_login_view_is_access() {
		$this->view('login')->assertSee("Авторизация");
	}

	public function test_login_route_is_access(): void
	{
		$response = $this->get('/login');
		$response->assertStatus(200);
	}

	public function test_success_authorization() {

		$response = $this->post('/login', [
			'login' => 'test_login',
			'password' => 'password'
		]);

		$response->assertRedirectToRoute('dashboard');
		$this->assertAuthenticatedAs($this->getTestUser());
	}

	public function test_fail_authorization() {

		$response = $this->post('/login', [
			'login' => 'abracadabra',
			'password' => 'password'
		]);

		$this->assertGuest();

		$response = $this->post('/login', [
			'login' => $this->getTestUser()->login,
			'password' => 'sadfasdf'
		]);

		$this->assertGuest();
	}

	//registration tests

	public function test_user_create_view() {
		$this->view('register')->assertSee('Регистрация');
	}

	public function test_register_route_is_access() {
		$response = $this->get('/register');
		$response->assertStatus(200);
	}

	public function test_success_user_create() {

		$newUserData = [
			'login' => 'some_login',
			'first_name' => 'someName',
			'last_name' => 'someLastName',
			'password' => 'test_password'
		];

		$this->assertDatabaseMissing('users', $newUserData);

		$response = $this->post('/register', $newUserData);

		$response->assertRedirectToRoute('login');
		unset($newUserData['password']);
		$this->assertDatabaseHas('users', $newUserData);

	}

	// logout

	public function test_logout() {

		$response = $this
			->actingAs($this->getTestUser())
			->get('/logout');

		$response->assertRedirect('/login');
		$this->assertGuest();
	}
}
