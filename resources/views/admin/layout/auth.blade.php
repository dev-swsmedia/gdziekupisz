<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Prenumerata SWS | Zarządzanie</title>
  <!-- jQuery -->
  <script src="{{ asset('storage/js/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('storage/js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('storage/css/admin/adminlte.min.css') }}">

</head>
<body class="login-page" style="min-height: 466px;">
	<div class="login-box">
			@yield('content')
		</div>
	</div>

    <!-- AdminLTE App -->
    <script src="{{ asset('storage/js/admin/adminlte.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('storage/css/admin/custom.css') }}" />

    </script>
</body>
