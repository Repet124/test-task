@extends('layouts.auth')

@section('title', 'Login')

@section('form')

	<form action="/login" method="POST">
		@csrf
		<x-form.input name="login" label="Login" placeholder="Enter your login..."/>
		<x-form.password/>
		<x-submit/>
	</form>

@endsection
