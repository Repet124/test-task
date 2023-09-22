@extends('layouts.auth')

@section('title', 'Registration')

@section('form')

	<form action="/register" method="POST">
		@csrf
		<x-form.input name="login" label="Login" placeholder="Enter your login..."/>
		<x-form.input name="first_name" label="First name" placeholder="Enter your first name..."/>
		<x-form.input name="last_name" label="Last name" placeholder="Enter your last name..."/>
		<x-form.input name="password" label="Password" placeholder="Enter your password..." type="password"/>
		<x-form.input name="password_confirm" label="Password confirming" placeholder="Confirm your password..." type="password"/>
		<x-submit/>
	</form>

@endsection
