<?php
function shortcode_grid( $atts ) {
	extract( shortcode_atts( array(
		'num' => 10,
		'geo' => 0
	), $atts ) );

	$ret      = '';
	$b_static = carbon_get_theme_option( 'grid' );
	$b_hover  = carbon_get_theme_option( 'grid_hover' );
	if ( $b_static || $b_hover ) {
		$ret .= "<style>";
		if ( $b_static ) {
			$ret .= '.grid_rating a.play{background: ' . $b_static . '! important;}';
		}
		if ( $b_hover ) {
			$ret .= '.grid_rating a.play:hover{background: ' . $b_hover . '! important;}';
		}
		$ret .= "</style>";
	}
	wp_reset_query();
	/*welcome */
	$ret  .= '<div class="flex2 grid_rating">';
	$args = array(
		'post_type'      => 'casino',
		'posts_per_page' => $num,
		'order'          => 'DESC',
		'meta_key'       => '_rating',
		'orderby'        => 'meta_value_num',
	);
	if ( $geo ) {
		//Fetch RC terms
		$current_user_country = get_user_country();
		$term_args            = array( 'taxonomy' => 'restricted', 'number' => 999, 'hide_empty' => false );
		$terms                = get_terms( $term_args );
		$term_ids             = array();
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$val = carbon_get_term_meta( $term->term_id, 'iso' );
				if ( $val == $current_user_country ) {
					$term_ids[] = $term->term_id;
				}
			}
		}
		if ( sizeof( $term_ids ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'restricted',
					'field'    => 'id',
					'terms'    => $term_ids,
					'operator' => 'NOT IN',
				)
			);
		}
	}
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ):
			$query->the_post();
			$ret .= load_template_part( 'loop/casino-grid-item' );
		endwhile;
	} else {
		return '<span style="color: red;">' . __( 'No casino reviews found', 'jgambling' ) . '</span></div>';
	}
	$ret .= '</div>';
	if ( $query->max_num_pages > 1 ) :
		$ret .= '<button class="loadmore grid">' . __( 'Load more', 'jgambling' ) . '</button>';
	endif;


	if ( $query->max_num_pages > 1 ) :
		if ( get_query_var( 'paged' ) ):
			$pn = get_query_var( 'paged' );
		else:
			$pn = 1;
		endif;
		$ret .= '<script>
                    var ajaxurl = "' . site_url() . '/wp-admin/admin-ajax.php";
                    var posts = \'' . serialize( $query->query_vars ) . '\';
                    var current_page = ' . $pn . ';
                    var max_pages = "' . $query->max_num_pages . '";
                 </script>';
	endif;


	return $ret;
}


add_shortcode( 'grid', 'shortcode_grid' );