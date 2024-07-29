@extends('web.layout.web')

@section('content')
	<div class="row">
		<div class="col-md-12 text-center">
			<h1>Znajdź najbliższy punkt sprzedaży</h1>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-md-12">
			@include('web.home.partials.form')		
		</div>
	</div>
	@if(request()->lat !== null && request()->lng !== null)
	<div class="row mt-5">
		<div class="col-md-12 text-center">
			<a href="{{ route('web.index') }}" class="btn btn-lg btn-outline-danger">Pokaż wszystkie punkty</a>
		</div>
	</div>
	@endif
	<div class="row mt-5">
		<div class="col-lg-8">
			@include('web.home.partials.map')
		</div>
		<div class="col-lg-4">
			@include('web.home.partials.pos_table')
		</div>
	</div>
	@if(count($blog) > 0)
	<div class="row mt-5">
		<div class="col-md-12 text-center">
			<h1>Nowości</h1>
		</div>
	</div>
	<div class="row mt-1">
		@include('web.home.partials.blog')
	</div>	
	@endif
	<script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
	<link href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css" rel="stylesheet"/>	
	@include('web.partials.map_script')
	<script>
	       	$('#pos-list').DataTable( {
        	ordering: false,
           	lengthChange: false,
            info: false,
            language: {
            	url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/pl.json',
            	paginate: {
                    first: '<i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>',
                    last: '<i class="fa fa-chevron-right"><i class="fa fa-chevron-right"></i>',
                    next: '<i class="fa fa-chevron-right"></i>',
                    previous: '<i class="fa fa-chevron-left"></i>'
                }
            },
            "drawCallback": function(nRow, data) {
        	    	$('tbody td').on('click', function() {
        	    		var lat = $(this).parent('tr').attr('data-lat');
        	    		var lng = $(this).parent('tr').attr('data-lng');
        	    		map.flyTo([lat,lng], 18, { duration: 2 });
        	    	});
        	      }  
            });
	</script>
	<style>
	.dt-container { font-size: 10pt !important; }
	</style>
@endsection