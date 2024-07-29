@extends('admin.layout.admin')

@section('title_header')
Menadżer plików
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active">Menadżer plików</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{ route('admin.filesmanager.edit') }}"><button class="btn btn-primary float-right"><i class="fas fa-plus mr-1"></i>Dodaj plik</button></a>						
			</div>
			<div class="card-body">
				<div class="fileTypeFilter mb-3">
					<strong>Pokaż pliki typu:&nbsp;</strong>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="">Wszystkie</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="image"><i class="far fa-image mr-2"></i>Obrazy</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="pdf"><i class="far fa-file-pdf mr-2"></i>PDF</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="ms-excel"><i class="far fa-file-excel mr-2"></i>XLS</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="openxmlformats-officedocument.spreadsheetml.sheet"><i class="far fa-file-excel mr-2"></i>XLSX</button>					
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="msword"><i class="far fa-file-word mr-2"></i>DOC</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="openxmlformats-officedocument.wordprocessingml.document"><i class="far fa-file-word mr-2"></i>DOCX</button>					
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="text/plain"><i class="far fa-file mr-2"></i>TXT</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="audio"><i class="far fa-music mr-2"></i>Audio</button>
					<button type="button" class="btn btn-outline-secondary typeSelector" data-type="video"><i class="far fa-video mr-2"></i>Wideo</button>
				</div>
				<div class="table-responsive">
                  <table class="table table-hover">
                  	<thead>
                  		<tr>
                  		<th>ID</th>
                  		<th>Podgląd</th>
                  		<th>Tytuł</th>
                  		<th>Opis</th>
                  		<th>Typ</th>
                  		<th style="width: 250px;"></th>
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
	var typeFilterVal = "{{ request()->type }}";
	
	$('.typeSelector[data-type="' + typeFilterVal + '"]').removeClass('btn-outline-secondary').addClass('btn-secondary');

	$('.typeSelector').on('click', function() {
		var type = $(this).attr('data-type');
		window.location.href = "{{ route('admin.filesmanager.index') }}?type=" + type;
	});


    $('table').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": {
            "url": "{{ route('admin.ajax.filesmanager.dt_getfiles') }}?type=" + typeFilterVal,
        },
     
        "columns": [
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "width": "250px", "orderable": false, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "width": "250px", "orderable": false, "className": "cursor-pointer align-middle" }
		              
                  ],
        "language": {
            "url": ""
        },
	    "drawCallback": function(nRow, data) {
	    	$('tbody td:not(:last-child)').on('click', function() {
	    		var id = $(this).parent('tr').find('td:first-child').html();
	    		window.location.href = "{{ route('admin.filesmanager.edit') }}/" + id;
	    	});

	    	$('.deleteFile').on('click', function() {
	    		var href = $(this).attr('data-href');
	    		var title = $(this).attr('data-title');
	    		
	    		bootbox.confirm({
	    			className: 'bb-danger',            		
	    			title: 'Usuwanie pliku',
	    	        message: 'Czy na pewno chcesz usunąć plik: "' + title + '"?',
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
		    		title: 'Adres URL pliku',
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