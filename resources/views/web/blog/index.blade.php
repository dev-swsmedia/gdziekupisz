@extends('web.layout.web')

@section('content') 
		<div class="row">
			<div class="col-md-12 mb-5">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('web.index') }}">Strona główna</a></li>                    
                    @if($current == null)
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    @else
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('web.blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $current }}</li>
                    @endif
                  </ol>
                </nav>
			</div>
		</div>
				<div class="row">
					<div class="col-lg-9 order-lg-2">
						<div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
							@foreach($posts->items() as $b)
							<div class="col-lg-4 col-sm-6">
								@include('web.partials.blog_item')
							</div>
							@endforeach																				
						</div>
						<!-- Pagination Block -->
						<div class="row pt-3">
							<div class="col-md-12">
								<div class="pagination-block">
									{{ $posts->links('vendor.pagination.web') }}
								</div>
							</div>
						</div>

					</div>
					<div class="col-lg-3  mt--0 mt-lg-0">
						<div class="inner-page-sidebar">
							<!-- Accordion -->
							<div class="single-block">
								<a href="{{ route('web.blog.index') }}" class="w-100"><h3 class="sidebar-title">{{ $category }}</h3></a>
								<ul class="sidebar-menu--shop">
									@foreach($categories as $c)
									<li @if(request()->segment(2) == $c->category_url) class="cat-active" @endif><a href="{{ route('web.blog.index', $c->category_url) }}">{{ $c->category_name }}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>

	
							
@endsection