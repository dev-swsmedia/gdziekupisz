<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gdzie Kupisz | Zarządzanie</title>
    <!-- jQuery -->
    <script src="{{ asset('storage/js/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Moment.js -->
  	<script src="{{ asset('storage/js/plugins/moment/moment-with-locales.min.js') }}"></script>	
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('storage/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!--  Popper -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('storage/js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('storage/css/admin/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Datetime picker -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" >
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/select2/css/select2.min.css') }}">  
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">  
    <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('storage/js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		@include('admin.layout.partials.header')
		@include('admin.layout.partials.sidebar')
	    <!-- Content Wrapper. Contains page content -->
  		<main class="content-wrapper">
  			<!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0">@yield('title_header')</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="nav-icon fas fa-home"></i></a></li>
                      @yield('breadcrumbs')
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
  			<section class="content">
			@yield('content')
			</section>
		</main>
	</div>
	@include('admin.layout.partials.footer')

	  <!-- Datetime picker -->
  	<script src="{{ asset('storage/js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	  <!-- Input mask -->
  	<script src="{{ asset('storage/js/plugins/inputmask/jquery.inputmask.min.js') }}"></script>  	
    <!-- ChartJS -->
    <script src="{{ asset('storage/js/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('storage/js/plugins/datatables/jQuery.dataTables.min.js') }}"></script>
    <script src="{{ asset('storage/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <link rel="stylesheet" href="{{ asset('storage/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <!-- Select2 -->
    <script src="{{ asset('storage/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootbox -->
    <script src="{{ asset('storage/js/plugins/bootbox/bootbox.all.min.js') }}"></script>    
    <!-- AdminLTE App -->
    <script src="{{ asset('storage/js/admin/adminlte.js') }}"></script>
    
    
    <script src="{{ asset('storage/js/admin/functions.js') }}?{{ time() }}"></script>
    
    <link rel="stylesheet" href="{{ asset('storage/css/admin/custom.css') }}?{{ time() }}" />
    
    <script>
		$(document).ready(function() {
		    @if(session()->has('message'))				
			showAlert('Zrobione!', '{{ session()->get('message') }}', 'bg-success', 'fa-check');
		    @endif

	        @if($errors->any())

				showAlert('Błąd', '<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}   </ul>', 'bg-danger', 'fa-exclamation-triangle');
	            
	        @endif
	        @isset($adminCurrentTab)
			setCurrentTab('{{ $adminCurrentTab }}');
			@endisset
		});
    </script>
    <div class="modal fade" id="loader" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
        <div class="modal-dialog modal-dialog-centered modal-sm">
        	<div class="modal-content">
        		<div class="modal-body">
        		     <div class="d-flex justify-content-center mt-5">
                      <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                        <span class="sr-only">Wczytywanie...</span>
                      </div>
                    </div>
                    <div class="w-100 text-center mt-3 mb-5">Proszę czekać...</div>                    
        		</div>
        	</div>
    
    	</div>
	
	</div>
</body>
