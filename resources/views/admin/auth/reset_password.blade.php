@extends('admin.layout.auth')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
    	<a href="{{ route('admin.index') }}" class="h1"><b>Gdzie</b>Kupisz</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Podaj swój adres e-mail, by zmienić hasło</p>
        @if($errors->any())
        <div class="alert alert-danger">
            {!! implode('', $errors->all('<div>:message</div>')) !!}        
        </div>
        @endif
        @if(session()->has('message'))
        <div class="alert alert-info">
        	{!! session()->get('message') !!}
        </div>
        @endif
        <form action="{{ route('admin.password.reset.action') }}" method="post">
        	@csrf
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="E-mail" name="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                    	<span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
               	 <button type="submit" class="btn btn-primary btn-block">Wyślij </button>
                </div>            
            </div>
            <div class="row">
            	<div class="col-md-12">
            		<a class="btn btn-link btn-block mt-3" href="{{ route('admin.index') }}">Powrót</a>
            	</div>
            </div>
        </form>

    </div>

</div>
@endsection