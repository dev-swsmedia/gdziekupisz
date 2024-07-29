@extends('admin.layout.admin')

@section('title_header')
Plik <strong>@isset($file) {{ $file->file_name }} @else nowy @endisset</strong>
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.filesmanager.index') }}">Menadżer plików</a></li>
<li class="breadcrumb-item active">@isset($file) {{ $file->file_name }} @else Nowy plik @endisset</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<form enctype="multipart/form-data" class="card" @isset($file) action="{{ route('admin.filesmanager.save', $file->file_id) }}" @else action="{{ route('admin.filesmanager.save') }}" @endisset method="POST">
			<div class="card-header">
				<a href="{{ route('admin.filesmanager.index') }}"><button class="btn btn-secondary float-left" type="button"><i class="fas fa-times mr-1"></i>Anuluj</button></a>	
				<button class="btn btn-primary float-right" type="submit"><i class="fas fa-save mr-1"></i>Zapisz plik</button>						
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="file_name">Nazwa pliku:</label>
					<input type="text" name="file_name" class="form-control" @isset($file) value="{{ $file->file_name }}" @endisset />
				</div>
				<div class="form-group">
					<label for="file_name">Opis pliku:</label>
					<input type="text" name="file_desc" class="form-control" @isset($file) value="{{ $file->file_description }}" @endisset />
				</div>
				@isset($file)
				@else
				<div class="form-group">
					<label for="file_name">Plik:</label>
					<input type="file" name="file" class="form-control" />
				</div>				
				@endisset			
			</div>
			@csrf
		</form>

	</div>
</div>

@endsection