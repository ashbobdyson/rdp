<?php
$args = array(
    'post_type' => 'client_area',
    'posts_per_page' => -1,
);

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :
    $un = 0;
    while ( $the_query->have_posts() ) : $the_query->the_post();
        $clientTitle = get_the_title() . ' - ' .$un;
        echo '<h1>'.$clientTitle.'</h1>';
        $oldArray = get_field('products');
        $newArray = get_field('products');
        $i = 0;
        foreach (get_field('products') as $productRow) {
            if($productRow['to_sync']) {
                $newArray[$i]['product'] = createProduct($productRow['to_sync']['id'], $clientTitle.' - '.$i);
                $newArray[$i]['to_sync'] = '';
            } else {
                echo '<p>Product already Synced</p>';
            }
            $i++;
        }
        update_field('field_5bc651445b2c3', $newArray, $post_id);
        $un++;
    endwhile;
endif;

function createProduct($imageID, $clientTitle) {
    $update = false;
    $productTitle = $clientTitle . ' - '. get_the_title($imageID);
    $price = 0;
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'product',
        'meta_key'		=> 'id',
        'meta_value'    => $productTitle,
    ));

    if ($posts) :
			echo '<p>Post Found - '.get_the_title($imageID).' updating existing product</p>';
		$update = true;
            // echo print_r($posts);
		$post_id = $posts[0]->ID;
    endif;

    if (!$update) : //creating new post
        $post = array(
			'post_content' => '',
			'post_status' => "publish",
			'post_title' => $productTitle,
			'post_parent' => '',
			'post_type' => "product",
			'post_excerpt' => ''
		);
        //Create post
		$post_id = wp_insert_post($post);
        update_field('field_5bc651445b2c3', $newArray, $post_id);
    endif;

    update_field('field_5bc79c8def72c', $productTitle, $post_id);

    $terms = array( 'exclude-from-catalog', 'exclude-from-search' );
    wp_set_object_terms( $post_id, $terms, 'product_visibility' );

    // update_post_meta($post_id, '_regular_price', (float)$price);
    // update_post_meta($post_id, '_price', (float)$price);
    wp_set_object_terms($post_id, 'variable', 'product_type', false );

    $parent_id = $post_id;

    // $attrs = array(
    //     array('giclee-fine-art-print-gloss-9x6'),
    //     array('giclee-fine-art-print-gloss-12x8'),
    //     array('giclee-fine-art-print-gloss-15x10'),
    //     array('fine-art-canvas-wrap-12x8'),
    //     array('fine-art-canvas-wrap-18x12'),
    //     array('fine-art-canvas-wrap-24x16'),
    // );


    $attrs = array(
        array('giclee-fine-art-print-gloss-9x6', '10.00'),
        array('giclee-fine-art-print-gloss-9x6', '10.00'),
        array('giclee-fine-art-print-gloss-12x8', '15.00'),
        array('giclee-fine-art-print-gloss-15x10', '17.50'),
        array('fine-art-canvas-wrap-12x8', '70.00'),
        array('fine-art-canvas-wrap-18x12', '75.00'),
        array('fine-art-canvas-wrap-24x16', '120.00'),
    );

    $attrs2 = array(
        array('Giclée Fine Art Print Gloss (9×6)', '10.00'),
        array('Giclée Fine Art Print Gloss (9×6)', '10.00'),
        array('Giclée Fine Art Print Gloss (12x8)', '15.00'),
        array('Giclée Fine Art Print Gloss (15x10)', '17.50'),
        array('Fine Art Canvas Wrap (12x8)', '70.00'),
        array('Fine Art Canvas Wrap (18x12)', '75.00'),
        array('Fine Art Canvas Wrap (24x16)', '120.00'),
    );

    // $i = 1;
    // foreach ($attrs2 as $attr) {
    //     // create_variaiton($post_id, $attr[0], $attr[1], $i);
    //     wp_set_object_terms($post_id, $attr[0], 'pa_client-size' , true);
    //     $i++;
    // }

    $i = 0;
    foreach ($attrs2 as $attr) {
        $term_taxonomy_ids = wp_set_object_terms( $post_id, $attr[0], 'pa_client-size', true );
        $thedata = Array('pa_client-size'=>Array(
            'name'=>'pa_client-size',
            'value'=>$attr[0],
            'is_visible' => '1',
            'is_taxonomy' => '1',
            'is_variation' => 1,
        ));
        update_post_meta( $post_id,'_product_attributes',$thedata);
        create_variaiton($attr[0], $attr[1], $post_id, $attrs[$i][0]);
        $i++;
    }

    set_post_thumbnail( $post_id, $imageID);

    return $post_id;
}

function create_variaiton($_name, $_price, $post_id, $_slug) {
    // In a class constructor
    $size_tax = wc_attribute_taxonomy_name( 'Client-Size' );
    // to create multiple variations with multiple values
    $parent_id = $product_id;
    $variation = array(
        'post_title'   => 'Product #' . $post_id . ' Variation',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_parent'  => $post_id,
        'post_type'    => 'product_variation'
    );
    // The variation id
    $variation_id = wp_insert_post( $variation );
    // Regular Price ( you can set other data like sku and sale price here )
    update_post_meta( $variation_id, '_regular_price', $_price );
    update_post_meta( $variation_id, '_price', $_price );
	update_post_meta( $variation_id, '_stock_status', 'instock');
    // Assign the size and color of this variation
    update_post_meta( $variation_id, 'attribute_' . $size_tax, $_slug );
    // Update parent if variable so price sorting works and stays in sync with the cheapest child
    WC_Product_Variable::sync( $post_id );
}
?>
