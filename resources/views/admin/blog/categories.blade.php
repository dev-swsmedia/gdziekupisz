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
				<button class="btn btn-primary float-right" data-toggle="modal" data-target="#categoryModal"><i class="fas fa-plus mr-1"></i>Nowa kategoria</button>						
			</div>
			<div class="card-body">
				<div class="table-responsive">
                  <table class="table table-hover">
                  	<thead>
                  		<tr>
                  		<th>ID</th>
                  		<th>Nazwa kategorii</th>
                  		<th></th>
                  		</tr>
                  	</thead>
                  	<tbody>
                  		@foreach($categories as $c)
                  		<tr data-id="{{ $c->id }}" data-name="{{ $c->category_name }}" data-url="{{ $c->category_url }}">
                  			<td>{{ $c->id }}</td>
                  			<td>{{ $c->category_name }}</td>
                  			<td><button class="btn btn-sm btn-danger delete" data-title="{{ $c->category_name }}" data-href="{{ route('admin.blog.categories.delete', $c->id) }}" type="button"><i class="fas fa-trash"></i></button></td>
                  		</tr>
                  		@endforeach
                  	</tbody>
                  </table>
                </div>
			</div>
		</div>

	</div>
</div>


<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalTitle">Kategoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="categoryForm" action="{{ route('admin.blog.categories.save') }}">
			<div class="card-body">
				<div class="form-group">
					<label for="category_name">Nazwa kategorii<span class="text-danger">*</span>:</label>
					<input type="text" name="category_name" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label for="category_url">URL kategorii:</label>
					<input type="text" name="category_url" class="form-control" />
				</div>								
			</div>
			<input type="hidden" name="id" value="" />			
			@csrf
		</form>		
      </div>
      <div class="modal-footer">
         	<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
        	<button type="button" class="btn btn-primary" id="saveCategory">Zapisz</button>     		
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#categoryModal').on('hidden.bs.modal', function (e) {
			$('input[name="id"]').val('');
			$('input[name="category_name"]').val('');
	 });
	 
	$('#saveCategory').on('click', function() {
		if($('input[name=category_name]').val().length == 0) { 
			showAlert('Popraw dane', 'Pole "Nazwa kategorii" nie może być puste.');
			return false;
		}
		
		$('#categoryForm').submit();
	});

    $('table').DataTable( {
	    "drawCallback": function(nRow, data) {	
	    	$('tbody td:not(:last-child)').on('click', function() {    	
    	    	var id = $(this).parent('tr').attr('data-id');
    	    	var name = $(this).parent('tr').attr('data-name');
    			var url = $(this).parent('tr').attr('data-url');
    			
    			$('input[name="id"]').val(id);
    			$('input[name="category_name"]').val(name);
    			$('input[name="category_url"]').val(url);
    
    			$('#categoryModal').modal('show');			
			});
			
	    	$('.delete').on('click', function() {

	    		var title = $(this).attr('data-title');
	    		var href = $(this).attr('data-href');
	    		
	    		bootbox.confirm({
	    			className: 'bb-danger',            		
	    			title: 'Usuwanie kategorii',
	    	        message: 'Czy na pewno chcesz usunąć kategorię: "' + title + '"?',
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