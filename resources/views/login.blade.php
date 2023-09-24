@extends('layouts.auth')

@section('title', 'Авторизация')

@section('form')

	<form method="POST" action="/login" class="col-5">
		@csrf
		<div class="mb-3">
			<label for="inputLogin1" class="form-label">Логин пользователя</label>
			<input required name="login" type="text" class="form-control" id="inputLogin1">
		</div>
		<div class="mb-3">
			<label for="inputPassword1" class="form-label">Пароль</label>
			<input required name="password" type="password" class="form-control" id="inputPassword1">
		</div>
		<button type="submit" class="btn btn-primary">Войти</button>
	</form>

@endsection
