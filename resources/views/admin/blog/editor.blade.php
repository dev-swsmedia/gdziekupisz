@extends('admin.layout.admin')

@section('title_header')
Blog <strong>/ @isset($post){{ $post->post_title }}@else Nowa strona @endisset</strong>
@endsection

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog</a></li>
<li class="breadcrumb-item active">@isset($post){{ $post->post_title }}@else Nowa strona @endisset</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<form method="POST" @isset($post) action="{{ route('admin.blog.save', $post->id) }}" @else action="{{ route('admin.blog.save') }}" @endisset>
		@csrf	
    		<div class="card">
    			<div class="card-header">
    				<button type="submit" class="btn btn-primary float-right"><i class="fas fa-save mr-1"></i>Zapisz</button>
    				<a href="{{ route('admin.blog.index') }}"><button class="btn btn-secondary float-left" type="button"><i class="fas fa-times mr-1"></i>Anuluj</button></a>				
    			</div>
    			<div class="card-body">
    					<div class="row">
    						<div class="col-md-10">
    							<label for="post_title">Tytuł wpisu</label>
    							<input type="text" name="post_title" class="form-control" @isset($post) value="{{ $post->post_title }}" @else value="{{ old('post_title') }}" @endisset required="required" />
    						</div>
    						<div class="col-md-2">
    							<label for="active">Status</label>
    							<select class="form-control custom-select" name="active">
    								<option value="1" @if(isset($post) && $post->active == 1) selected="selected" @endif>Opublikowany</option>
    								<option value="0" @if(isset($post) && $post->active == 0) selected="selected" @endif>Nieopublikowany</option>
    							</select>
    						</div>
    						<div class="col-md-10 mt-3">
    							<label for="post_title">Adres URL strony</label>
    							<div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <button class="btn btn-outline-secondary" type="button" id="post_url">Zmień</button>
                                  </div>
    								<input type="text" name="post_url" data-set="0" class="form-control" @isset($post) value="{{ $post->post_url }}" @else value="{{ old('post_url') }}" @endisset readonly="readonly" />
                                </div>
    						</div>
    						<div class="col-md-2 mt-3">
    							<label for="post_category">Kategoria</label>
    							<select class="form-control custom-select" name="post_category">
    								<option value="0" @selected(old('post_category') == null)>brak</option>
    							@foreach($categories as $c)
    								<option value="{{ $c->id }}" @selected(old('post_category') == $c->id)>{{ $c->category_name }}</option>
    							@endforeach
    							</select>
    						</div>	    						
    						<div class="col-md-6 mt-3">
    							<label for="post_seo_keywords">Meta keywords</label>
    							<input type="text" name="post_seo_keywords" class="form-control" @isset($post) value="{{ $post->post_seo_keywords }}" @else value="{{ old('post_seo_keywords') }}" @endisset /> 
    						</div>
    						<div class="col-md-6 mt-3">
    							<label for="post_seo_description">Meta description</label>
    							<input type="text" name="post_seo_description" class="form-control" @isset($post) value="{{ $post->post_seo_description }}" @else value="{{ old('post_seo_description') }}" @endisset /> 
    						</div>    						
    						<div class="col-md-12 mt-3">
    							<label for="post_image">Zdjęcie</label><br />
    							@php
    							    $image = asset('storage/images/no_photo.png');
                                    if(isset($post) && $post->post_image !== null && str_contains($post->post_image, 'http')) {
                                        $image = $post->post_image;
                                    } else if(isset($post) && $post->post_image !== null) {
                                        $image = asset('storage/uploads/'.$post->post_image);
                                    }
    							@endphp
    							<img src="{{ $image }}" style="height: 200px; max-width: 100%;" class="mb-3 img-prev" />
    							<div class="input-group">
    								<input type="text" name="post_image" class="form-control note-image-url" @isset($post) value="{{ $post->post_image }}" @else value="{{ old('post_image') }}" @endisset />
    								<div class="input-group-append">
    									<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#imageSelectorModal">Wybierz plik</button>
    								</div>
    							</div>    							
    						</div>
    						<div class="col-md-12 mt-3">
    							<label for="post_lead">Lead</label>
    							<textarea name="post_lead" style="height: 250px;">@isset($post){!! $post->post_lead !!}@else{!! old('post_lead') !!}@endisset</textarea>
    						</div>    						
    						<div class="col-md-12 mt-3">
    							<label for="post_content">Treść wpisu</label>
    							<textarea name="post_content">@isset($post){!! $post->post_content !!}@else{!! old('post_content') !!}@endisset</textarea>
    						</div>																	
    					</div>
    			</div>
    		</div>
		</form>
	</div>
</div>

@include('admin.partials.wysiwyg_editor')
<script>
$(document).ready(function() {
	  $('#post_url').on('click', function () {
		    var prev = $('input[name="post_url"]'),
		        ro = prev.prop('readonly');
		    prev.prop('readonly', !ro).focus();
		    $(this).html(ro ? 'Zastosuj' : 'Zmień');
		  });


		  $('input[name="post_title"]').on('keyup', function () {
		    if ($('input[name="post_url"]').attr('data-set') == 0) {
		      $('input[name="post_url"]').val(url_slug($('input[name="post_title"]').val()));
		    }
		  });

		  $('input[name="post_url"]').on('keyup', function () {
		    $(this).val(slug($(this).val()));
		  });
});

	setInterval(function() {
		  	var href =  $('input[name="post_image"]').val();
		  	if(href == '') {
		  		href = '{{ asset('storage/images/no_photo.png') }}';
		  	}
		  	$('.img-prev').attr('src', href);
	}, 200);
</script>
@endsection