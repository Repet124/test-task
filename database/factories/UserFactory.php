<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'login' => fake()->unique()->userName(),
			'first_name' => fake()->word(),
			'last_name' => fake()->word(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'remember_token' => Str::random(10),
		];
	}

	public function testUser(): Factory {
		return $this->state(fn () => [
			'login' => 'test_login',
			'first_name' => 'testname',
			'last_name' => 'lastname',
		]);
	}

	public function addRandomCountEvents($from, $to): Factory {

		return $this->afterCreating(
			fn (User $user) => Event::factory()->count(rand($from, $to))->for($user, 'creator')->create()
		);
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	// public function unverified(): static
	// {
	// 	return $this->state(fn (array $attributes) => [
	// 		'email_verified_at' => null,
	// 	]);
	// }
}
