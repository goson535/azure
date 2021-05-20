<?php
function shortcode_slots( $atts ) {
	extract( shortcode_atts( array(
		'num'      => 10,
		'software' => '',
		'more'     => '1',
	), $atts ) );
	wp_reset_query();
	$args = array(
		'post_type'      => 'slots',
		'posts_per_page' => $num,
	);
	if ( $software ) {
		$add_tax = array(
			'taxonomy' => 'software',
			'field'    => 'slug',
			'terms'    => $software
		);
	}
	$args['tax_query'][] = $add_tax;
	$query               = new WP_Query( $args );
	if ( $query->have_posts() ) {
		$ret = '<div class="slots small ajax_block"><div class="flex2">';
		while ( $query->have_posts() ):
			$query->the_post();
			$ret .= load_template_part( 'loop/slot-item' );
		endwhile;
		$ret .= '</div></div>';
		if ( $query->max_num_pages > 1 AND $more ) :
			$ret .= '<script>
                            var ajaxurl = \'' . site_url() . '/wp-admin/admin-ajax.php\';
                            var posts = \'' . serialize( $query->query_vars ) . '\';
                            var current_page = ' . ( ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1 ) . ';
                            var max_pages = \'' . $query->max_num_pages . '\';
                      </script>
                        <button class="loadmore slotoload">' . __( "Load more", "jgambling" ) . '</button>';
		endif;
	} else {
		return '<span style="color: red;">' . __( 'No casino reviews found', 'jgambling' ) . '</span>';
	}

	return $ret;
}

add_shortcode( 'slots', 'shortcode_slots' );