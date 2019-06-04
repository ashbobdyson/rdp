@extends('layouts.app')

@section('content')
  <div class="shop-catalog">
      @while(have_posts()) @php the_post() @endphp
      @php the_content() @endphp
    @endwhile
      
  </div>
@endsection
