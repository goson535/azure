<?php
//search_bonus
function search_bonus() {
	$s               = $_POST['s'];
	$per_page_global = carbon_get_theme_option( 'bonus_count' );
	if ( $per_page_global ) {
		$perpage = $per_page_global;
	} else {
		$perpage = 6;
	}


	$args = array(
		'post_type'      => array( 'bonus' ),
		's'              => $s,
		'posts_per_page' => $perpage,

	);
	if ( $_POST['type'] ) {
		$args['tax_query'] = [
			'relation' => 'AND',
			[
				'taxonomy' => 'type',
				'field'    => 'slug',
				'terms'    => $_POST['type']
			]
		];
	}
	$ret = '<div class="bonus-list flex2">';
	$q   = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$ret .= load_template_part( 'loop/bonus-item' );
		endwhile;
	else:
		$ret .= '<h2 style="color: #ff1f1f;    font-size: 15px;">' . __( 'Nothing found...', 'jgambling' ) . '</h2>';
	endif;
	$ret .= '</div>';
	if ( $q->max_num_pages > 1 ) :

		if ( get_query_var( 'paged' ) ) {
			$pn = get_query_var( 'paged' );
		} else {
			$pn = 1;
		}
		$ini = serialize( $q->query_vars );
		$new = str_replace( "'", '"', $ini );
		$ret .= "<script type='application/javascript'>
                    var ajaxurl = '" . site_url() . "/wp-admin/admin-ajax.php'; ";

		$ret .= "var posts = '" . $new . "'; ";

		$ret .= "var current_page = " . $pn . ";
                    var max_pages = '" . $q->max_num_pages . "';
                 </script>";
		$ret .= '<button class="loadmore bonusload">'.__( 'Load more', 'jgambling' ).'</button>';
	endif;
	echo $ret;
	die();

}


add_action( 'wp_ajax_search_bonus', 'search_bonus' );
add_action( 'wp_ajax_nopriv_search_bonus', 'search_bonus' );