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
	 * Display the specified resource.
	 */
	public function show(Event $event)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Event $event)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Event $event)
	{
		//
	}
}
