@extends('layouts.app')

@section('content')
	<div class="press-side">
		<h1>{!! get_the_title() !!}</h1>
		<!-- <p class="info">{!! get_field('caption') !!}</p> -->
		<!-- <p class="exif">{!! do_shortcode('[exif id="'.get_post_thumbnail_id().'"]') !!}</p> -->
		<div class="keywords">
			<h3>Keywords</h3>
			@foreach(get_field('images')[0]['keywords'] as $kw)
				<p class="keyword">{!! $kw['keyword'] !!}</p>
			@endforeach
		</div>
		<a href="/press" class="back">@include('icons.tail-left') Back</a>
	</div>
  <div class="press-main">
    <div class="m-grid" style="opacity: 0; transform: translateY(50px);">
		@foreach(get_field('images') as $im )
			<div class="press-item col-md-6 col-12 m-grid-item" data-lightbox="{!! wp_get_attachment_image_src(get_post_thumbnail_id($im['product']->ID), 'full')[0] !!}">
				<div class="lightbox-btn">@include('icons.zoom-e')</div>
				<div class="hover-info">
					<h4>{!! get_the_title($im['product']->ID) !!}</h4>
					<p>{!! get_post($im['product']->ID)->post_content !!}</p>
				</div>
				<img <?= create_srcset(get_post_thumbnail_id($im['product']->ID)) ?>/>
				<a class="full-link no-barba" href="<?= get_permalink($im['product']->ID) ?>"></a>
			</div>
        @endforeach
    </div>
  </div>
@endsection
