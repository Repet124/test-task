<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
			return redirect()->route('dashboard');
		}
		return redirect()->back()->withErrors(['message'=>'Неверный логин или пароль']);
	}

	public function create() {
		return view('register');
	}

	public function store(Request $request) {
		$credentials = $request->validate([
			'login' => 'required|unique:users|max:20|min:2',
			'password' => 'required|min:8',
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
		]);

		$user = User::create($credentials);

		return redirect()->route('login');
	}

	public function logout(Request $request) {
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('login');
	}

	public function show(User $user) {
		if ($user) {
			return response()->json([
				'err' => null,
				'result' => $user
			]);
		}
	}

}
