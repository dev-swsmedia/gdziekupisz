@extends('admin.layout.admin')

@section('title_header')
Pulpit
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active">Pulpit</li>
@endsection

@section('content')
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row h-100">
		<div class="col-lg-8">
			@include('web.home.partials.map')
		</div>
		<div class="col-lg-4">
			@include('web.home.partials.pos_table')
		</div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

</div>

	<script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
	<link href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css" rel="stylesheet"/>
    <script src="{{ asset('storage/js/functions.js') }}?{{ date('YmdH') }}"></script>
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