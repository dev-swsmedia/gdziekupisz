@extends('admin.layout.admin')

@section('title_header')
POS
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active">POS</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{ route('admin.pos.edit') }}"><button class="btn btn-primary float-right"><i class="fas fa-plus mr-1"></i>Nowy POS</button></a>
				<button class="btn btn-outline-secondary float-right mr-2" data-toggle="modal" data-target="#importModal"><i class="fas fa-plus mr-1"></i>Importuj z CSV</button>					
			</div>
			<div class="card-body">
				<div class="table-responsive">
                  <table class="table table-hover">
                  	<thead>
                  		<tr>
                  		<th>ID</th>
                  		<th>Kategoria</th>
                  		<th>Nazwa</th>
                  		<th>Miejscowość</th>
                  		<th>Adres</th>
                  		<th>Kod pocztowy</th>
                  		<th>Lat</th>
                  		<th>Lng</th>
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

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Importuj z pliku CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.pos.import') }}" enctype="multipart/form-data">
      <div class="modal-body">
      	<div class="alert alert-warning">
      		<p>
          		Plik powinien zostać przygotowany wg. poniższych wskazówek:
          		<ul>
          			<li>
          				Każda linia w pliku to oddzielny POS
          			</li>
          			<li>
          				Brak wiersza z nagłówkami kolumn – pierwszy wiersz zawiera od razu dane
          			</li>
          			<li>
          				Dane POS wg. wzoru<br />
          				<code>nazwa;kod_pocztowy;miejscowość;ulica;numer;lat;lng;nazwa_kategorii</code>
          			</li>
          		</ul>
      		</p>
      	</div>
      	<div class="form-group">
      		<label for="file">Plik CSV:</label>
      		<input class="form-control" type="file" name="file" accept="text/csv" required="required" />
      	</div>
      	@csrf
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        <button type="submit" class="btn btn-primary">Importuj</button>
      </div>
      </form>
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
            "url": "{{ route('admin.ajax.pos.dt_get') }}",
        },
     
        "columns": [
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },		              
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },		              
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle" },
		              { "orderable": true, "className": "cursor-pointer align-middle" },
		              { "orderable": false, "className": "cursor-pointer align-middle" }
                  ],
        "language": {
            "url": ""
        },
	    "drawCallback": function(nRow, data) {
	    	$('tbody td:not(:last-child)').on('click', function() {
	    		var id = $(this).parent('tr').find('td:first-child').html();
	    		window.location.href = "{{ route('admin.pos.edit') }}/" + id;
	    	});

	    	$('.delete').on('click', function() {

	    		var title = $(this).attr('data-title');
	    		var href = $(this).attr('data-href');
	    		
	    		bootbox.confirm({
	    			className: 'bb-danger',            		
	    			title: 'Usuwanie POS',
	    	        message: 'Czy na pewno chcesz usunąć POS: "' + title + '"?',
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
	      }        
    });
} );

</script>
@endsection