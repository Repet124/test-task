<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventDestroyRequest;
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
			'errors' => null,
			'result' => Event::with(['creator', 'members'])->get()
		]);
	}

	public function show($id) {
		return response()->json([
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
				'result' => true
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Event $event, EventDestroyRequest $request) {

		$event->delete();

		return response()->json([
			'result' => true
		]);
	}

	public function involve(Event $event) {
		$event->members()->attach(auth()->user());
		return response()->json([
			'result' => true
		]);
	}

	public function leave(Event $event) {
		$event->members()->detach(auth()->user());
		return response()->json([
			'result' => true
		]);
	}
}
