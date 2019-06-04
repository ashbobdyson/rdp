<?php
$args = array(
    'post_type' => 'press_item',
	'posts_per_page' => -1,
	'post_status'      => array('publish','future'),
);

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :
    $un = 0;
    while ( $the_query->have_posts() ) : $the_query->the_post();
        $title = get_the_title();
        echo '<h1>'.$title.'</h1>';
        $oldArray = get_field('images');
		$newArray = get_field('images');
		$caption = '';
        $i = 0;
        foreach (get_field('images') as $productRow) {
            if($productRow['to_sync']) {
				echo '<p>Creating Post</p>';
				if($i == 0) :
					$caption = wp_get_attachment_caption($productRow['to_sync']['id']);
				endif;
				$__product = createProduct($productRow['to_sync']['id'], basename(get_attached_file( $productRow['to_sync']['id'])));
                $newArray[$i]['product'] = $__product;
				$newArray[$i]['to_sync'] = '';
				//IPTC Keywords
				$img = wp_get_attachment_image_src($productRow['to_sync']['id'], 'full')[0];
				$size = getimagesize($img, $info);
				$keywordsArray = [];
				$kwi = 0;
				if(isset($info['APP13']))
				{
					$iptc = iptcparse($info['APP13']);
					$keyword0 = $iptc["2#025"][0];
					if($keyword0 == "") {$keyword0 = "";} else {$keyword0 = $keyword0;}
					$keywords = $keyword0;
					foreach(explode(';', $keywords) as $kw) :
						$keywordsArray[$kwi]['keyword'] = $kw;
						$kwi++;
					endforeach;
				} elseif(isset($info["2#025"])) {
					echo '<h2 style="color:red;">None found in APP13 but found in 2#025</h2>';
				} else {
					echo '<h1 style="color:red;">NO KEYWORDS FOUND!!</h1>';
				}
				$newArray[$i]['keywords'] = $keywordsArray;
            } else {
				echo '<p>Product already Synced</p>';
			}
			echo print_r($newArray);
            $i++;
        }
		update_field('field_5be867cf2abd9', $newArray, $post_id);
		update_field('field_5be9f9afa28e4', $caption, $post_id);
        $un++;
    endwhile;
endif;

function createProduct($imageID, $title) {
    $update = false;
    $productTitle = $title;
    $price = 0;
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'product',
        'meta_key'		=> 'id',
        'meta_value'    => $productTitle,
    ));

    if ($posts) :
			echo '<p>Post Found - '.$title.' updating existing product</p>';
		$update = true;
            // echo print_r($posts);
		$post_id = $posts[0]->ID;
    endif;

    if (!$update) : //creating new post
        $post = array(
			'post_content' => wp_get_attachment_caption($imageID),
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
    wp_set_object_terms($post_id, 'variable', 'product_type', false );

	$parent_id = $post_id;

	$attrs = array(
		array('', ''),
        array('personal-use', '25.00'),
		array('publication-use', '125.00'),
    );

    $attrs2 = array(
		array('', ''),
        array('Personal Use', '25.00'),
		array('Publication Use', '125.00'),
	);

    $i = 0;
    foreach ($attrs2 as $attr) {
        $term_taxonomy_ids = wp_set_object_terms( $post_id, $attr[0], 'pa_usage', true );
        $thedata = Array('pa_usage'=>Array(
            'name'=>'pa_usage',
            'value'=>$attr[0],
            'is_visible' => '1',
            'is_taxonomy' => '1',
            'is_variation' => 1,
        ));
        update_post_meta( $post_id,'_product_attributes',$thedata);
        create_variaiton($attr[0], $attr[1], $post_id, $attrs[$i][0], $imageID);
        $i++;
    }

	set_post_thumbnail( $post_id, $imageID);

	//IPTC Keywords
	$img = wp_get_attachment_image_src($imageID, 'full')[0];
	$size = getimagesize($img, $info);
	if(isset($info['APP13']))
	{
		$iptc = iptcparse($info['APP13']);
		$keyword0 = $iptc["2#025"][0];
		if($keyword0 == "") {$keyword0 = "";} else {$keyword0 = $keyword0;}
		$keywords = $keyword0;
		wp_set_object_terms($post_id, explode(';', $keywords), 'product_tag');
	}

    return $post_id;
}

function create_variaiton($_name, $_price, $post_id, $_slug, $_image) {
    $size_tax = wc_attribute_taxonomy_name( 'usage' );
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
	update_post_meta( $variation_id, '_downloadable', 'yes');
	update_post_meta( $variation_id, '_virtual', 'yes');

	//other method
	$product = wc_get_product( $variation_id );
	$pd_object = new WC_Product_Download();
	if( $_slug != '' ) :
		if( $_slug == 'personal-use' ) :
			$file_url  = get_field('personal_license', 'option')['url'];
			$pd_object->set_name( 'Personal Use License' );
		elseif( $_slug == 'publication-use' ) :
			$file_url  = get_field('publication_license', 'option')['url'];
			$pd_object->set_name( 'Publication Use License' );
		endif;
		$download_id = md5( $file_url );
		$pd_object->set_id( $download_id );
		$pd_object->set_file( $file_url );

		$_item = wc_get_product( $variation_id );

		echo print_r($__item);

		// Get existing downloads (if they exist)
		$downloads = $product->get_downloads();

		// Add the new WC_Product_Download object to the array
		$downloads[$download_id] = $pd_object;

		// Set the complete downloads array in the product
		$product->set_downloads($downloads);
		$product->save(); // Save the data in database
	endif;

	$pd_object = new WC_Product_Download();
	if( $_slug != '' ) :
		$file_url  = wp_get_attachment_image_src($_image, 'full')[0];
		$pd_object->set_name( get_the_title($_image) );
		$download_id = md5( $file_url );
		$pd_object->set_id( $download_id );
		$pd_object->set_file( $file_url );

		$_item = wc_get_product( $variation_id );

		echo print_r($__item);

		// Get existing downloads (if they exist)
		$downloads = $product->get_downloads();

		// Add the new WC_Product_Download object to the array
		$downloads[$download_id] = $pd_object;

		// Set the complete downloads array in the product
		$product->set_downloads($downloads);
		$product->save(); // Save the data in database
	endif;

    // Assign the size and color of this variation
    update_post_meta( $variation_id, 'attribute_' . $size_tax, $_slug );
    // Update parent if variable so price sorting works and stays in sync with the cheapest child
	WC_Product_Variable::sync( $post_id );
}
?>
