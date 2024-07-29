@extends('web.layout.web')

@section('content')
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">   
                    	<li class="breadcrumb-item"><a href="{{ route('web.index') }}">Strona główna</a></li>                   
                        <li class="breadcrumb-item"><a href="{{ route('web.blog.index') }}">Blog</a></li>
                        @if($category !== null)
                        <li class="breadcrumb-item"><a href="{{ route('web.blog.index', $category->category_url) }}">{{ $category->category_name }}</a></li>
                        @endif
                        <li class="breadcrumb-item">{{ $post->post_title }}</li>                        
                    </ul>
                </nav>
            </div>
	@if($post->post_image !== null)
	<div class="row mt-3">
		@php
			$image = null;
			if(str_contains($post->post_image, 'http')) {
				$image = $post->post_image;
			} else if($post->post_image !== null) {
				$image = asset('storage/uploads/'.$post->post_image);
			}
		@endphp
		@if($image !== null)
		<div class="col-12">
			<div class="post-image" style="background: url('{{ $image }}') no-repeat; width: 100%; height: 450px; background-size: cover; background-position: center;"></div>	
		</div>
		@endif
	</div>
	@endif
	<div class="row mt-3">
		<div class="col-12">
			<h1>{{ $post->post_title }}</h1>		
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
			<small class="text-muted">Dodano: {{ $post->created_at->format('d.m.Y H:i') }}@if($post->updated_at !== null && $post->updated_at <> $post->created_at), aktualizacja: {{ $post->updated_at->format('d.m.Y H:i') }}@endif</small>
			@if($post->post_ai == true)<small class="badge badge-secondary bg-secondary float-end">Wygenerowane przez AI</small>@endif
			<hr />
		</div>		
	</div>
	<div class="row">
		<div class="col-12">
			{!! $post->post_content !!}	
		</div>
	</div>	
@endsection