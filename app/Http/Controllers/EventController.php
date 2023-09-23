<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return response()->json([
			'events' => Event::with(['creator', 'members'])->get()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$credentials = $request->validate([
			'title' => 'required|max:255|unique:events',
			'description' => 'required'
		]);

		$credentials['creator_id'] = auth()->user()->id;

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
}
