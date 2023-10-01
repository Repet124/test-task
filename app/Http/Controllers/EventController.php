<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return response()->json([
			'error' => null,
			'result' => Event::with(['creator', 'members'])->get()
		]);
	}

	public function show($id) {
		return response()->json([
			'error' => null,
			'result' => Event::with(['creator','members'])->where('id', $id)->first()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(EventStoreRequest $request) {

		$credentials = $request->validated();

		if (Event::create($credentials)) {
			return response()->json([
				'error' => null,
				'result' => true
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Event $event) {
		if (auth()->user()->id === $event->creator->id) {
			$event->delete();
			return response()->json([
				'error'=> null,
				'result' => true
			]);
		}
		return response()->json([
			'error' => 'creator id dont match with user',
			'result' => false
		]);
	}

	public function involve(Event $event) {
		$user = auth()->user();

		if($event->members->contains($user)) {
			return response()->json([
				'error' => 'you are already involvments',
				'result' => false
			]);
		}
		$event->members()->attach($user->id);
		return response()->json([
			'error' => null,
			'result' => true
		]);
	}

	public function leave(Event $event) {
		$user = auth()->user();

		if($event->members->contains($user)) {
			$event->members()->detach($user->id);
			return response()->json([
				'error' => null,
				'result' => true
			]);
		}
		return response()->json([
			'error' => 'you are not involments in event',
			'result' => false
		]);
	}
}
