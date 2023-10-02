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
			->count(4)
			->addRandomCountEvents(from: 0, to: 3)
			->create();

		// seeding members for events
		Event::all()->each(function($event) {
			$this->assignMembersForEvent($event);
		});

	}

	protected function assignMembersForEvent($event, $from=0, $to=5) {
		$event
			->members()
			->attach(
				User::all() // BAD PRACTIC!!! MUST BE SINGLETON!!! It was maked for a code reading usefully
					->random(rand($from, $to)) // Users for that event
					->map(fn(User $user) => $user->id) // users collection to users id collection
			);
	}
}
