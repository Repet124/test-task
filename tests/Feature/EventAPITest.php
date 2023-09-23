<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EventAPITest extends TestCase {

	use RefreshDatabase;

	public function test_getting_events_list() {

		$event = Event::factory()->create()->first();
		$usersId = User::factory(3)->create()->map(fn($user) => $user->id);
		$event->members()->attach($usersId);

		$response = $this->get('/api/events');

		$response
			->assertJson(fn (AssertableJson $json) =>
				$json->has('events', 1,fn (AssertableJson $json) =>
					$json->where('title', $event->title)
						->where('description', $event->description)
						->where('creator.id', $event->creator->id)
						->where('creator.first_name', $event->creator->first_name)
						->where('creator.last_name', $event->creator->last_name)
						->has('members', 3, fn (AssertableJson $json) =>
							$json->where('id', $event->members[0]->id)
								->etc()
					)->etc()
				)
			);

	}

	public function test_success_creating_event() {
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->post('/api/events',[
				'title' => 'test_title',
				'description' => 'test_description',
			]);

		$response->assertOk();

		$event = Event::all()->first();

		$this->assertEquals($event->title, 'test_title');
		$this->assertEquals($event->description, 'test_description');
		$this->assertEquals($event->creator->id, $user->id);
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
