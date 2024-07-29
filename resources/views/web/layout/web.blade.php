<!DOCTYPE html>
<html lang="pl">
<head>
@include('web.layout.partials.head')
</head>
<body>
	@include('web.layout.partials.header')

	<main class="container pb-5">

	@yield('content')
	
	
	</main>
	@include('web.layout.partials.footer')
	
    <script src="{{ asset('storage/js/plugins/bootbox/bootbox.all.min.js') }}"></script>    
    <script src="{{ asset('storage/js/web/custom.js') }}?{{ date('YmdHi') }}"></script>
    <script>
    @if(session('message'))
     $(document).ready(function() {
    	bootbox.alert({
        	@isset(session()->get('message')['message'])
            message: "<h5 class='text-center'>{!! session()->get('message')['message'] !!}</h5>",
            @else
            message: "<h5 class='text-center'>{!! session()->get('message') !!}</h5>",
            @endisset
            locale: 'pl',
            className: 'modal-alert'
        });
     });
    @endif
	@if ($errors->any())
	     $(document).ready(function() {
	     	bootbox.alert({
				 message: '<h5 class="text-center">Wystąpiły następujące błędy: <ul>@foreach ($errors->all() as $error)  <li>{{ $error }}</li> @endforeach</ul></h5>',
	             locale: 'pl',
	             className: 'modal-alert'
	         });
	      });
    @endif
    </script>
</body>
