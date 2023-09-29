<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Database\Seeders\TestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EventAPITest extends TestCase {

	use RefreshDatabase;

	protected $seed = true;
	protected $seeder = TestingSeeder::class;

	public function test_getting_events_list() {

		$user = $this->getTestUser();

		$response = $this
			->actingAs($user)
			->get('/api/events');

		$response->assertJson([
			'error' => null,
			'result' => Event::with(['creator', 'members'])->get()->toArray()
		]);

	}

	public function test_success_creating_event() {
		$newEventData = [
			'title' => 'test_title',
			'description' => 'test_description',
		];
		$user = $this->getTestUser();

		$response = $this
			->actingAs($user)
			->post('/api/events', $newEventData);

		$response->assertOk();
		$this->assertDatabaseHas('events', array_merge(
			$newEventData,
			['creator_id' => $user->id]
		));
	}

	public function test_fail_creating_event() {
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->post('/api/events',[
				'title' => '',
				'descripton' => 'test_description',
			]);

		$this->assertEquals(Event::all()->count(), 0);
	}

	public function test_destroy_event() {
		$event = Event::factory()->create();

		$response = $this
			->actingAs($event->creator)
			->delete("/api/events/$event->id");

		$response->assertJson([
			'error' => null
		]);

		$this->assertEquals(Event::all()->count(), 0);
	}

	public function test_fail_destroy_event() {
		$event = Event::factory()->create();
		$otherUser = User::factory()->create();

		$response = $this
			->actingAs($otherUser)
			->delete("/api/events/$event->id");

		$response->assertJson([
			'error' => 'creator id dont match with user'
		]);

		$this->assertEquals(Event::all()->count(), 1);
	}

	public function test_request_for_involving_user_in_event() {
		$event = Event::factory()->create();
		$otherUser = User::factory()->create();

		$response = $this
			->actingAs($otherUser)
			->get("/api/events/$event->id/involve");

		$this->assertEquals($event->members->last()->id, $otherUser->id);
	}

	public function test_to_dismiss_user_from_event() {
		$event = Event::factory()->create();
		$otherUser = User::factory()->create();
		$event->members()->attach($otherUser->id);

		$response = $this
			->actingAs($otherUser)
			->get("/api/events/$event->id/leave");

		$this->assertEquals($event->members->count(), 0);
	}

}
