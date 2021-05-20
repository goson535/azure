<?php
function shortcode_news( $atts ) {
	extract( shortcode_atts( array(
		'num'      => 10,
		'category' => '',
		'more'     => '1',
	), $atts ) );
	wp_reset_query();
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $num,
	);
	if ( $category ) {
		$add_tax = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => $category
		);
	}
	$args['tax_query'][] = $add_tax;
	$query               = new WP_Query( $args );
	if ( $query->have_posts() ) {
		$ret = '<div class="articles-page"><div class="flex article-items"> ';
		while ( $query->have_posts() ):
			$query->the_post();
			$ret .= load_template_part( 'loop/post-simple-item' );
		endwhile;
		$ret .= '</div>';
		if ( $query->max_num_pages > 1 AND $more ) :
			$ret .= '<script>
                            var ajaxurl = \'' . site_url() . '/wp-admin/admin-ajax.php\';
                            var posts = \'' . serialize( $query->query_vars ) . '\';
                            var current_page = ' . ( ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1 ) . ';
                            var max_pages = \'' . $query->max_num_pages . '\';
                      </script>
                        <button class="load_more_category">' . __( "Load more", "jgambling" ) . '</button>';
		endif;
		$ret .= '</div>';
	} else {
		return '<span style="color: red;">' . __( 'No casino reviews found', 'jgambling' ) . '</span>';
	}

	return $ret;
}

add_shortcode( 'jnews', 'shortcode_news' );