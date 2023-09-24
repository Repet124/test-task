<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<title>@yield('title')</title>
		<style>
			body {
				background-color: #f4f6f9;
				padding-top: 50px;
			}
		</style>
	</head>
	<body>
		@if($errors->any())

			<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">@yield('title'): Ошибка</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							@foreach ($errors->all() as $error)
								<p class="text-danger">{{ $error }}</p>
							@endforeach
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
						</div>
					</div>
				</div>
			</div>

		@endif
		<div class="container ">
			<div class="row justify-content-md-center">
				<h1 class="h3 col-5 text-center">@yield('title')</h1>
			</div>
			<div class="row h-100 justify-content-md-center align-items-center">
				@section('form')
				@show
			</div>
		</div>
		@vite('resources/js/auth.js')
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		@if($errors->any())
		<script>
			let myModal = new bootstrap.Modal(document.getElementById('myModal'), {
				keyboard: false
			});
			myModal.show();
		</script>
		@endif
	</body>
</html>
