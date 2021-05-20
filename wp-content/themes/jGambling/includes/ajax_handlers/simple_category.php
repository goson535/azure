<?php
function load_posts_category() {

	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged']       = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
	$args['post_type']   = 'post';


	$query = new WP_Query( $args );
	// print_r($query);
	if ( $query->have_posts() ) :

		while ( $query->have_posts() ): $query->the_post();
			  get_template_part( 'loop/post-simple-item' );

		endwhile;
	endif;
	die();
}

add_action( 'wp_ajax_loadmore_categories', 'load_posts_category' );
add_action( 'wp_ajax_nopriv_loadmore_categories', 'load_posts_category' );
