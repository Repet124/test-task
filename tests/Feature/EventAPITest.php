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

		$event = Event::factory()->create()[0];

		$response = $this->get('/api/events');

		$response
			->assertStatus(201)
			->assertJson(fn (AsserttableJson $json) =>
				$json->has('events', 1,fn (AsserttableJson $json) =>
					$json->where('title', $event->title)
						->where('description', $event->descripton)
						->where('creator.id', $event->creator->id)
						->where('creator.first_name', $event->creator->first_name)
						->where('creator.last_name', $event->creator->last_name)
						->has('members', 3, fn (AsserttableJson $json) =>
							$json->where('id', $event->members[0]->id)
								->etc()
						)
				)
			);

	}

	public function test_success_creating_event() {
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->post('/api/events/create',[
				'title' => 'test_title',
				'descripton' => 'test_description',
			]);

		$response->assertOk();

		$event = Event::all()->first();

		$response->assertEquals($event->title, 'test_title');
		$response->assertEquals($event->descripton, 'test_description');
		$response->assertEquals($event->creator->id, $user->id);
	}

	public function test_fail_creating_event() {
		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->post('/api/events/create',[
				'title' => '',
				'descripton' => 'test_description',
			]);

		$response->assertEquals(Event::all()->count(), 0);
	}

	public function test_destroy_event() {
		$event = Event::factory()->create();

		$response = $this
			->actingAs($event->creator)
			->delete("/api/events/$event->id");

		$response->assertEquals(Event::all()->count(), 0);
	}

	public function test_fail_destroy_event() {
		Event::factory()->create();
		$otherUser = User::factory()->create();

		$response = $this
			->actingAs($otherUser)
			->delete("/api/events/$event->id");

		$response->assertEquals(Event::all()->count(), 0);
	}

	public function test_request_for_involving_user_in_event() {
		$event = Event::factory()->create();
		$otherUser = User::factory()->create();

		$response = $this
			->actingAs($otherUser)
			->get("/api/events/$event->id/involve");

		$response->assertEquals($event->members->last(), $otherUser);
	}

	public function test_to_dismiss_user_from_event() {
		$event = Event::factory()->create();
		$otherUser = User::factory()->create();
		$event->addMember($otherUser);

		$response = $this
			->actingAs($otherUser)
			->get("/api/events/$event->id/leave");

		$response->assertNotEquals($event->members->last(), $otherUser);
	}

}
