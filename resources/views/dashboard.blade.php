<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ Vite::asset('node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ Vite::asset('node_modules/admin-lte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini" >

<!-- ./wrapper -->
<div id="app" class="wrapper"data-user="{{json_encode($user)}}"></div>
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ Vite::asset('node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ Vite::asset('node_modules/admin-lte/dist/js/adminlte.min.js') }}"></script>
<script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>
</html>
