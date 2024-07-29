<div class="modal fade" id="imageSelectorModal" tabindex="-1" role="dialog" aria-labelledby="imageSelectorModalTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog  modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageSelectorModalTitle">Wybierz plik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#fileUploadModal"><i class="fa fa-plus mr-2"></i>Dodaj plik</button>      
      	<div class="table-responsive">
     		<table class="table table-hover img-table w-100">
     			<thead>
     				<th>ID</th>     			
     				<th>Podgląd</th>
     				<th>Nazwa pliku</th>
     				<th></th>
     			</thead>
     			<tbody>
     			</tbody>
     		</table> 
     		</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="fileSelectorModal" tabindex="-1" role="dialog" aria-labelledby="imageSelectorModalTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog  modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileSelectorModalTitle">Wybierz plik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#fileUploadModal"><i class="fa fa-plus mr-2"></i>Dodaj plik</button>
      	<div class="table-responsive">
     		<table class="table table-hover file-table w-100">
     			<thead>
     				<th>ID</th>
     				<th>Podgląd</th>
     				<th>Nazwa pliku</th>
     				<th></th>
     			</thead>
     			<tbody>
     			</tbody>
     		</table> 
     		</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageSelectorModalTitle" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileUploadModalTitle">Dodaj plik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="uploadFileForm">
			<div class="card-body">
				<div class="form-group">
					<label for="file_name">Nazwa pliku<span class="text-danger">*</span>:</label>
					<input type="text" name="file_name" class="form-control" />
				</div>
				<div class="form-group">
					<label for="file_name">Opis pliku:</label>
					<input type="text" name="file_desc" class="form-control" />
				</div>
				<div class="form-group">
					<label for="file_name">Plik<span class="text-danger">*</span>:</label>
					<input type="file" name="file" class="form-control" />
				</div>				
			</div>
			<input type="hidden" name="ajax" value="1" />
			@csrf
		</form>		
      </div>
      <div class="modal-footer">
         	<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
        	<button type="button" class="btn btn-primary" id="uploadFile">Dodaj plik</button>     		
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('storage/js/plugins/summernote/summernote-bs4.js') }}"></script>
<link rel="stylesheet" href="{{ asset('storage/js/plugins/summernote/summernote-bs4.css') }}" />
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-pl-PL.js"></script>
<script>
$(document).ready(function() {
	$('textarea').summernote({
		lang: "pl-PL",
		height: @isset($height) {{ $height }} @else 500 @endif
	});
	
	$('#uploadFile').on('click', function() {
		if($('input[name=file_name]').val().length == 0) { 
			showAlert('Popraw dane', 'Pole "Nazwa pliku" nie może być puste.');
			return false;
		}
		
		if($('input[name=file]').val().length == 0) { 
			showAlert('Popraw dane', 'Musisz wybrać plik, który chcesz dodać.');
			return false;
		}
		
		loader();
		setTimeout(function() {		
    		$.ajax({
    			type: "POST",
    			url: "{{ route('admin.filesmanager.save') }}",
    			data: new FormData($('#uploadFileForm')[0]),
    			contentType: false,
        		processData: false,
    			success: function (data) {
    				loader();
    				if(data == 'OK') {
    					$('#fileUploadModal').modal('hide');
    					$('.file-table').DataTable().ajax.reload();
    					$('.img-table').DataTable().ajax.reload();
    				} else {
    					showAlert('Błąd', 'Nie udało się dodać pliku z powodu błędu: ' + data, 'bg-danger', 'fa-exclamation-triangle');
    				}
    		        $('#uploadFileForm')[0].reset();			
    			},
    			error: function(data) {  
    				loader();
    				showAlert('Błąd', 'Nie udało się dodać pliku z powodu błędu: ' + data, 'bg-danger', 'fa-exclamation-triangle');
    				$('#uploadFileForm')[0].reset();       	
    			}
    		});
    		}, 500);
	});

    $('.img-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": {
            "url": "{{ route('admin.ajax.filesmanager.dt_getfiles') }}?for=selector&type=image",
        },
     
        "columns": [
        		    { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle" }
		              
                  ],
        "language": {
            "url": ""
        },
	    "drawCallback": function(nRow, data) {
	    	$('.selectFile').on('click', function() {
	    		var url = $(this).attr('data-url');
	    		var title = $(this).attr('data-title');
				
				$('.note-image-url').val(url);
				$('#imageSelectorModal').modal('hide');
				$('.note-image-btn').prop('disabled', false);
	    	});
	      }        
    });
    
   	$('.file-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": {
            "url": "{{ route('admin.ajax.filesmanager.dt_getfiles') }}?for=selector",
        },
     
        "columns": [
        		    { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle"  },
		              { "orderable": true, "className": "cursor-pointer align-middle"  },
		              { "orderable": false, "className": "cursor-pointer align-middle" }
		              
                  ],
        "language": {
            "url": ""
        },
	    "drawCallback": function(nRow, data) {
	    	$('.selectFile').on('click', function() {
	    		var url = $(this).attr('data-url');
	    		var title = $(this).attr('data-title');
				
				$('.note-link-url, .note-link-text ').val(url);
				$('#fileSelectorModal').modal('hide');
				$('.note-link-btn').prop('disabled', false);
	    	});
	      }        
    });
    	
	$('.note-editor .note-group-select-from-files').hide();
	$('.note-editor .note-group-image-url').append('<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#imageSelectorModal">Wybierz plik</button>');
	$('.note-editor .note-link-url').after('<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#fileSelectorModal">Wybierz plik</button>');
	
});
</script>