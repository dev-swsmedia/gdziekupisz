@extends('admin.layout.admin')

@section('title_header')
Blog
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active">Blog</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{ route('admin.blog.edit') }}"><button class="btn btn-primary float-right"><i class="fas fa-plus mr-1"></i>Nowy wpis</button></a>						
			</div>
			<div class="card-body">
				<div class="table-responsive">
                  <table class="table table-hover">
                  	<thead>
                  		<tr>
                  		<th>ID</th>
                  		<th>Zdjęcie</th>
                  		<th>Tytuł wpisu</th>
                  		<th>Data dodania</th>
                  		<th>Status</th>
                  		<th></th>
                  		</tr>
                  	</thead>
                  	<tbody>
                  	</tbody>
                  </table>
                </div>
			</div>
		</div>

	</div>
</div>



<script>
$(document).ready(function() {

    $('table').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": {
            "url": "{{ route('admin.ajax.blog.dt_getPosts') }}",
        },
     
        "columns": [
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },		              
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle" }
		              
                  ],
        "language": {
            "url": ""
        },
	    "drawCallback": function(nRow, data) {
	    	$('tbody td:not(:last-child)').on('click', function() {
	    		var id = $(this).parent('tr').find('td:first-child').html();
	    		window.location.href = "{{ route('admin.blog.edit') }}/" + id;
	    	});

	    	$('.delete').on('click', function() {

	    		var title = $(this).attr('data-title');
	    		var href = $(this).attr('data-href');
	    		
	    		bootbox.confirm({
	    			className: 'bb-danger',            		
	    			title: 'Usuwanie storny',
	    	        message: 'Czy na pewno chcesz usunąć wpis: "' + title + '"?',
	    	        buttons: {
	    	        	confirm: {
	    	        		label: 'Tak',
	    	        		className: 'btn-primary'
	    	        	},
	    	        	cancel: {
	    	        		label: 'Nie',
	    	        		className: 'btn-secondary'
	    	        	}
	    	        },
	    	        callback: function (result) {
	    	        	if(result === true) window.location.href = href;
	    	        },
	    	        centerVertical: true
	    	    });
	    	});

	    	$('.previewLink').on('click', function() {
		    	var url = $(this).attr('data-url');
	    		bootbox.confirm({
		    		title: 'Adres URL wpisu',
                    message: '<input class="form-control" readonly id="url" value="' + url + '" />',
                    buttons: {
                        confirm: {
                        	label: 'Kopiuj',
                        	className: 'btn-secondary'
                        },
                        cancel: { 
							label: 'Anuluj',
							className: 'd-none'
                        }
                    },
                    callback: function (result) {
                        if(result == true)
                        {
							$('#url').select();
                        	document.execCommand('copy');
                    		showAlert('Skopiowano link', 'Link został skopiowany do schowka', 'bg-success', 'fa-info');
                        }
                    }
                    });
	    	});
	      }        
    });
} );

</script>
@endsection