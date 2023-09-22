<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	public function login() {
		return view('login');
	}

	public function auth(Request $request) {

		$credentials = $request->validate([
			'login' => 'required',
			'password' => 'required',
		]);

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			return response()->json(["status"=>"success"]);
		}
		return response()->json(["status"=>"err"], 403);

	}

	public function create() {
		return view('register');
	}

}
