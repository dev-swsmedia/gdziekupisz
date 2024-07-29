								@php
                        			$image = asset('storage/images/no_photo.png');
                        			if(str_contains($b->post_image, 'http')) {
                        				$image = $b->post_image;
                        			} else if($b->post_image !== null) {
                        				$image = asset('storage/uploads/'.$b->post_image);
                        			}
                        			
                        			$category_url = ($b->category !== null) ? $b->category->category_url : 0;
                        			
                        		@endphp        
        <div class="col" style="height: 369px;">
        	<a href="{{ route('web.blog.post', [$category_url, $b->id, $b->post_url]) }}" style="text-decoration: none;">
          <div class="card shadow-sm h-100">
			<div class="card-img-top w-100" style="height: 225px; background: url('{{ $image }}') no-repeat; background-size: cover; background-position: center;"></div>
            <div class="card-body">
            	<h3>{{ $b->post_title }}</h3>
              <p class="card-text">{!! $b->post_lead !!}</p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-body-secondary float-right">{{ $b->created_at->format('d.m.Y H:i') }}</small>
              </div>
            </div>
          </div>
          </a>
        </div>