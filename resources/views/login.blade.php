@extends('layouts.auth')

@section('title', 'Авторизация')

@section('form')

	<form method="POST" action="/login" class="col-5">
		<div class="mb-3">
			<label for="exampleInputEmail1" class="form-label">Логин пользователя</label>
			<input type="text" class="form-control" id="exampleInputLogin1">
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Пароль</label>
			<input type="password" class="form-control" id="exampleInputPassword1">
		</div>
		<button type="submit" class="btn btn-primary">Войти</button>
	</form>

@endsection
