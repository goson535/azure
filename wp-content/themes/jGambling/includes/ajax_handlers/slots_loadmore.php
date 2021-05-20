<?php

function load_slots() {
	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged']       = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
	query_posts( $args );
	if ( have_posts() ) :
		while ( have_posts() ): the_post();
			get_template_part( 'loop/slot-item' );
		endwhile;
	else:
		echo __( 'Nothing found...', 'jgambling' );
	endif;
	die();
}

add_action( 'wp_ajax_loadmore_slots', 'load_slots' );
add_action( 'wp_ajax_nopriv_loadmore_slots', 'load_slots' );