<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\TestingSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// User::create([
		// 	'login' => 'test',
		// 	'first_name' => 'test',
		// 	'last_name' => 'test',
		// 	'password' => 'password'
		// ]);
		// Event::factory(10)->create();
		$this->call([
			TestingSeeder::class
		]);

	}
}
