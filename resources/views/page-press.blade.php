@extends('layouts.app')

@section('content')
  <div class="press-main">
    <div class="m-grid" style="opacity: 0; transform: translateY(50px);">
    <?php
    //   $args = array(
    //     'post_type'      => 'product',
    //     'posts_per_page' => -1,
    //     'meta_query' => array(
    //         array(
    //             'key'       => '_visibility',
    //             'value'     => 'hidden',
    //             'compare'   => '!=',
    //         )
    //       ),
    // );

  $args = array(
    'post_type' => 'press_item',
    'posts_per_page' => -1,
  );

  $the_query = new WP_Query( $args ); 

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();?>
        <div class="press-item col-md-6 col-12 m-grid-item">
			<div class="gallery-info">
				<h3>{!! do_shortcode('[exif show="title" id="'.get_post_thumbnail_id().'"]') !!}</h3>
				<h4>{!! do_shortcode('[exif show="created_timestamp" id="'.get_post_thumbnail_id().'"]') !!}</h4>
			</div>
            <img <?= create_srcset(get_post_thumbnail_id()) ?>/>
            <a class="full-link" href="<?= get_permalink() ?>"></a>
        </div>
        <?php
        endwhile;
      endif;
      wp_reset_postdata();
    ?>
    </div>
  </div>
@endsection
