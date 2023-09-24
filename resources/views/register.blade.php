@extends('layouts.auth')

@section('title', 'Регистрация')

@section('form')

	<form method="POST" action="/register" class="col-5">
		<div class="mb-3">
			<label for="inputLogin1" class="form-label">Логин пользователя</label>
			<input required name="login" type="text" class="form-control" id="inputLogin1" value={{old('login')}}>
		</div>
		<div class="mb-3">
			<label for="inputFirstName1" class="form-label">Имя</label>
			<input required name="first_name" type="text" class="form-control" id="inputFirstName1" value={{old('first_name')}}>
		</div>
		<div class="mb-3">
			<label for="inputLastName1" class="form-label">Фамилия</label>
			<input required name="last_name" type="text" class="form-control" id="inputLastName1" value={{old('last_name')}}>
		</div>
		<div class="mb-3">
			<label for="inputPassword1" class="form-label">Пароль</label>
			<input required name="password" type="password" class="form-control" id="inputPassword1">
		</div>
		<div class="mb-3">
			<label for="inputConfirmPassword1" class="form-label">Подтверждение пароля</label>
			<input required name="confirm_password" type="password" class="form-control" id="inputConfirmPassword1">
			<p id="confirmInfoJS" class="d-none mt-3 text-danger">Пароли должны совпадать</p>
		</div>
		<button id="btnSubmitJS" type="submit" class="btn btn-primary">Регистрация</button>
	</form>

@endsection
