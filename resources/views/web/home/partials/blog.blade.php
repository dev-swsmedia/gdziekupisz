<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
@foreach($blog as $b)
	@include('web.partials.blog_item')
@endforeach
</div>
<div class="row mt-5">
	<div class="col-md-12 text-center">
		<a href="{{ route('web.blog.index') }}" class="btn btn-lg btn-danger">Zobacz więcej wpisów</a>
	</div>
</div>
