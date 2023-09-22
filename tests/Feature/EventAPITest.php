<?php

namespace Tests\Feature;

use App\Models\Event;
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

	}

	public function test_fail_creating_event() {
		// code...
	}

	public function test_destroy_event() {
		// code...
	}

	public function test_request_for_involving_user_in_event() {
		// code...
	}

	public function test_to_dismiss_user_from_event() {
		// code...
	}

}
