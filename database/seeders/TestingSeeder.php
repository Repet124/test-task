<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void {

		// test user
		$testUser = User::factory()
			->testUser()
			->hasEvents(2)
			->create();

		// test user involvments into self last event
		$testUser->events->last()->members()->attach($testUser->id);

		// creating users with events (random count)
		User::factory()
			->count(10)
			->addRandomCountEvents(from: 0, to: 3)
			->create();

		//test user involvments into other user event
		Event::where('creator_id', '!=', $testUser->id)->first()->members()->attach($testUser->id);

	}
}
