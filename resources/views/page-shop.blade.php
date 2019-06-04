@extends('layouts.app')

@section('content')
  <div class="shop-catalog">
    <div class="row">
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
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'exclude-from-catalog',
            'operator' => 'NOT IN',
        ),
    ),
  );

  $the_query = new WP_Query( $args ); 

    if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();?>
        <div class="shop-item col-md-6 col-12">
            <img <?= create_srcset(get_post_thumbnail_id()) ?>/>
            <a class="full-link no-barba" href="<?= get_permalink() ?>"></a>
        </div>
        <?php
        endwhile;
      endif;
      wp_reset_postdata();
    ?>
    </div>
  </div>
@endsection
