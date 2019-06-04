@extends('layouts.app')

@section('content')
  <div class="generic-page">
  <?php 
  if(get_field('content')) :
    while ( have_rows('content') ) : the_row();
      switch(get_row_layout()) :
        case 'image' : ?>
          @include('partials.content.image')
          <?php break;
        case 'text' :?>
          @include('partials.content.text')
          <?php break;
        case 'header' :?>
          @include('partials.content.header')
          <?php break;
        case 'subheader' :?>
          @include('partials.content.subheader')
          <?php break;
        case 'contact_form' :?>
          @include('partials.content.contact-form')
          <?php break;
      endswitch;
    endwhile;
  endif;
  ?> 
  </div>
@endsection
