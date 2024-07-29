@extends('admin.layout.admin')

@section('title_header')
POS <strong>/ @isset($pos){{ $pos->name }}, {{ $pos->city }}, {{ $pos->street }}@else Nowy POS @endisset</strong>
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.pos.index') }}">POS</a></li>
<li class="breadcrumb-item active">@isset($pos){{ $pos->name }}, {{ $pos->city }}, {{ $pos->street }}@else Nowy POS @endisset</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<form method="POST" @isset($pos) action="{{ route('admin.pos.save', $pos->id) }}" @else action="{{ route('admin.pos.save') }}" @endisset>
		@csrf	
    		<div class="card">
    			<div class="card-header">
    				<button type="submit" class="btn btn-primary float-right"><i class="fas fa-save mr-1"></i>Zapisz</button>
    				<a href="{{ route('admin.pos.index') }}"><button class="btn btn-secondary float-left" type="button"><i class="fas fa-times mr-1"></i>Anuluj</button></a>				
    			</div>
    			<div class="card-body">
    					<div class="row">
    						<div class="col-md-9">
    							<label for="post_title">Nazwa *</label>
    							<input type="text" name="name" class="form-control" @isset($pos) value="{{ $pos->name }}" @else value="{{ old('name') }}" @endisset required="required" />
    						</div>
    						<div class="col-md-3">
    							<label for="active">Kategoria *</label>
    							<select class="form-control custom-select" name="pos_category">
    								@foreach($categories as $c)
    								<option value="{{ $c->id }}" @if(isset($pos) && $pos->pos_category == $c->id) selected="selected" @endif>{{ $c->name }}</option>
    								@endforeach
    							</select>
    						</div>
    					</div>
    					<div class="row mt-2">
    						<div class="col-md-4">
    							<label for="city">Miejscowość *</label>
    							<input type="text" name="city" class="form-control" @isset($pos) value="{{ $pos->city }}" @else value="{{ old('city') }}" @endisset required="required" />
    						</div>
    						<div class="col-md-2">
    							<label for="city">Kod pocztowy</label>
    							<input type="text" name="postcode" class="form-control" @isset($pos) value="{{ $pos->postcode }}" @else value="{{ old('postcode') }}" @endisset />
    						</div>    						
    						<div class="col-md-4">
    							<label for="city">Ulica *</label>
    							<input type="text" name="street" class="form-control" @isset($pos) value="{{ $pos->street }}" @else value="{{ old('street') }}" @endisset required="required" />
    						</div>	
    						<div class="col-md-2">
    							<label for="number">Numer</label>
    							<input type="text" name="number" class="form-control" @isset($pos) value="{{ $pos->number }}" @else value="{{ old('number') }}" @endisset />
    						</div>	
    					</div>
    					<div class="row mt-2">
    						<div class="col-md-4">
    							<label for="lat">Latitude *</label>
    							<input type="text" name="lat" class="form-control" @isset($pos) value="{{ $pos->lat }}" @else value="{{ old('lat') }}" @endisset required="required" />
    						</div>
    						<div class="col-md-4">
    							<label for="lng">Longitude *</label>
    							<input type="text" name="lng" class="form-control" @isset($pos) value="{{ $pos->lng }}" @else value="{{ old('lng') }}" @endisset required="required" />
    						</div>     																									
    					</div>
    			</div>
    		</div>
		</form>
	</div>
</div>

@endsection