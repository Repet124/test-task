<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	public function login() {
		return view('login');
	}

	public function auth(AuthRequest $request) {

		$credentials = $request->validated();

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			return redirect()->route('dashboard');
		}
		return redirect()->back()->withErrors(['message'=>'Неверный логин или пароль']);
	}

	public function create() {
		return view('register');
	}

	public function store(RegisterRequest $request) {
		$credentials = $request->validated();

		$user = User::create($credentials);

		return redirect()->route('login');
	}

	public function logout(Request $request) {
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('login');
	}

	public function index() {
		return response()->json([
			'result' => User::all()
		]);
	}

	public function show(User $user) {
		if ($user) {
			return response()->json([
				'result' => $user
			]);
		}
	}

}
