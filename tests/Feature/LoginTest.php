<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
	use RefreshDatabase;
	/**
	 * A basic test example.
	 */
	public function test_login_route_is_access(): void
	{
		$response = $this->get('/login');
		$response->assertStatus(200);
	}
}
