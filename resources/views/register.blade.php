@extends('layouts.auth')

@section('title', 'Регистрация')

@section('form')

	<form method="POST" action="/register" class="col-5">
		<div class="mb-3">
			<label for="inputLogin1" class="form-label">Логин пользователя</label>
			<input required name="login" type="text" class="form-control" id="inputLogin1" value={{old('login')}}>
		</div>
		<div class="mb-3">
			<label for="inputPassword1" class="form-label">Пароль</label>
			<input required name="password" type="password" class="form-control" id="inputPassword1">
		</div>
		<div class="mb-3">
			<label for="inputConfirmPassword1" class="form-label">Подтверждение пароля</label>
			<input required name="confirm_password" type="password" class="form-control" id="inputConfirmPassword1">
		</div>
		<button id="btnSubmitJS" type="submit" class="btn btn-primary">Регистрация</button>
	</form>

@endsection
