@extends('admin.layout.admin')

@section('title_header')
Twój <strong>profil</strong>
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active">Twój profil</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<button form="userForm" class="btn btn-primary float-right"><i class="fas fa-save mr-1"></i>Zapisz</button>
				<a href="{{ route('admin.index') }}"><button class="btn btn-secondary float-left"><i class="fas fa-chevron-left mr-1"></i>Powrót</button></a>				
			</div>
		</div>
	</div>
</div>
<form method="POST" action="{{ route('admin.profile.save') }}" id="userForm">
@csrf
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5>Informacje o użytkowniku</h5>
			</div>
			<div class="card-body">
			<div class="table-responsive">
				 <table class="table table-hover">
				 	<tbody>
				 		<tr>
				 			<th class="align-middle">Adres e-mail</th>
				 			<td><input type="text" disabled="disabled" class="form-control" value="{{ $user->email }}" /></td>
				 		</tr>
				 		<tr>
				 			<th class="align-middle">Imię i nazwisko</th>
				 			<td><input type="text" class="form-control" name="user_display_name" value="{{ $user->user_display_name }}" /></td>
				 		</tr>
				 	</tbody>
				 </table>
				 </div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5>Hasło</h5>		
			</div>
			<div class="card-body">
				<div class="table-responsive">
                  <table class="table table-hover">					
                  	<tbody>
                  		<tr>
                  			<th class="align-middle">Nowe hasło</th>
                  			<td>
                  			<div class="input-group">
                              <input form="userForm" type="password" class="form-control" name="password" value="" aria-describedby="basic-addon2" />
                              
                              <div class="input-group-append">
                              	<button class="btn btn-default" id="showPass" type="button"><i class="fa fa-eye fa-eye-slash"></i></button>
                              </div>
                            </div>
                  			</td>
                  		</tr>
                  		<tr>
                  			<th class="align-middle">Powtórz nowe hasło</th>
                  			<td><input form="userForm" type="password" class="form-control" name="password_confirmation" value="" /></td>
                  		</tr>                   		     
                  	</tbody>
                  </table>
                </div>
			</div>
		</div>
	</div>	
</div>
</form>
<script>
$('#showPass').on('click', function() {
	$(this).find('i').toggleClass('fa-eye-slash');
	
	var field = $('input[name=password], input[name=password_confirmation]');

	if(field.attr('type') == 'password')
	{
		field.attr('type', 'text');
	}
	else
	{
		field.attr('type', 'password');
	}
});
</script>

@endsection