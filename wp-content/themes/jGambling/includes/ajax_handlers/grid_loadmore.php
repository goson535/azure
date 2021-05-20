<?php

function load_posts_grid() {
	$args                   = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged']          = $_POST['page'] + 1;
	$args['post_status']    = 'publish';
	query_posts( $args );
	if ( have_posts() ) :
		while ( have_posts() ): the_post();
			get_template_part( 'loop/casino-grid-item' );
		endwhile;
	endif;
	die();
}

add_action( 'wp_ajax_loadmore_grid', 'load_posts_grid' );
add_action( 'wp_ajax_nopriv_loadmore_grid', 'load_posts_grid' );