<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Database\Seeders\TestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class APITest extends TestCase {

	use RefreshDatabase;

	protected $seed = true;
	protected $seeder = TestingSeeder::class;

	public function test_getting_events_list() {

		Sanctum::actingAs($this->getTestUser(), ['*']);;

		$response = $this
			->getJson('/api/events');

		$response->assertJson([
			'errors' => null,
			'result' => Event::with(['creator', 'members'])->get()->toArray()
		]);

	}

	public function test_success_creating_event() {
		$newEventData = [
			'title' => 'test_title',
			'description' => 'test_description',
		];

		$user = $this->getTestUser();
		Sanctum::actingAs($user, ['*']);

		$response = $this
			->postJson('/api/events', $newEventData);

		$response->assertOk();
		$this->assertDatabaseHas('events', array_merge(
			$newEventData,
			['creator_id' => $user->id]
		));
	}

	public function test_fail_creating_event() {
		$eventsCount = Event::all()->count();

		Sanctum::actingAs($this->getTestUser(), ['*']);

		$response = $this
			->postJson('/api/events',[
				'title' => '',
				'description' => 'test_description',
			]);

		$response->assertUnprocessable();
		$response->assertJsonPath('message', 'Ошибка валидации данных');
		$response->assertJsonValidationErrors(['title']);
		$this->assertDatabaseCount('events', $eventsCount);
	}

	public function test_destroy_event() {
		$event = Event::all()->first();

		Sanctum::actingAs($event->creator, ['*']);

		$response = $this
			->deleteJson("/api/events/$event->id");

		$response->assertJson([
			'errors' => null
		]);

		$this->assertDatabaseMissing('events', [
			'id' => $event->id
		]);
	}

	public function test_fail_destroy_event() {
		$user = $this->getTestUser();
		$event = Event::where('creator_id', '!=', $user->id)->first();

		Sanctum::actingAs($user, ['*']);

		$response = $this
			->deleteJson("/api/events/$event->id");

		$response->assertForbidden();
		$response->assertJsonPath('message', 'Данное действие не доступно для вашего пользователя');
		$this->assertDatabaseHas('events', [
			'id' => $event->id
		]);
	}

	public function test_request_for_involving_user_in_event() {
		$event = Event::all()->first();
		$user = User::factory()->create();

		Sanctum::actingAs($user, ['*']);

		$response = $this
			->getJson("/api/events/$event->id/involve");

		$response->assertOk();
		$this->assertEquals($event->members->last()->id, $user->id);
	}

	public function test_to_dismiss_user_from_event() {
		$user = $this->getTestUser();
		$event = $user->involves()->first();

		Sanctum::actingAs($user, ['*']);

		$response = $this
			->get("/api/events/$event->id/leave");

		$response->assertOk();
		$this->assertDatabaseMissing('event_member', [
			'event_id' => $event->id,
			'member_id' => $user->id
		]);
	}

}
