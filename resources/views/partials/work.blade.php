<?php
$args = array(
    'post_parent' => $post->ID,
    'post_type' => 'page',
    'orderby' => 'menu_order'
);

$child_query = new WP_Query( $args );
?>

<div class="work-wrap">
    <div class="images">
    <?php while ( $child_query->have_posts() ) : $child_query->the_post(); ?>

        <div class="gallery-image-wrapper">
            <div class="blackout">
            </div>
            <div class="text-over">
                <p class="title">{{ get_the_title() }}</p>
                <p class="category">Portfolio</p>
            </div>
            <a class="link" href="{!! get_permalink() !!}"></a>
            <img <?= create_srcset(get_field('gallery')[0]['image']['id']) ?>/>
        </div>

    <?php endwhile; ?>
    </div>
</div>

<?php
wp_reset_postdata(); ?>