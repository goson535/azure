<?php
//search_slots
function search_slots() {
	$s               = $_POST['s'];
	$per_page_global = carbon_get_theme_option( 'slot_count' );
	if ( $per_page_global ) {
		$perpage = $per_page_global;
	} else {
		$perpage = 15;
	}


	$args = array(
		'post_type'      => array( 'slots' ),
		's'              => $s,
		'posts_per_page' => $perpage,

	);
	if ( $_POST['soft'] ) {
		$args['software'] = $_POST['soft'];
	}


	if ( $_POST['bonus_s'] == 1 ) {
		$args['meta_query'][] = array(
			'key'   => '_bonus_game',
			'value' => 'yes'
		);
	}
	if ( $_POST['free_spin_s'] == 1 ) {
		$args['meta_query'][] = array(
			'key'   => '_free_spins',
			'value' => 'yes'
		);
	}
	if ( $_POST['scatter_s'] == 1 ) {
		$args['meta_query'][] = array(
			'key'   => '_scatter_symbol',
			'value' => 'yes'
		);
	}
	if ( $_POST['wild_s'] == 1 ) {
		$args['meta_query'][] = array(
			'key'   => '_wild_symbol',
			'value' => 'yes'
		);
	}
	if ( $_POST['fast_speed_s'] == 1 ) {
		$args['meta_query'][] = array(
			'key'   => '_fast_spin',
			'value' => 'yes'
		);
	}
	$ret = '<div class="flex2">';
	$q   = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$ret .= load_template_part( 'loop/slot-item' );
		endwhile;
	else:
		$ret .= '<h2 style="color: #ff1f1f;    font-size: 15px;">'.__( 'Nothing found...', 'jgambling' ).'</h2>';
	endif;
	$ret .= '</div>';
	if ( $q->max_num_pages > 1 ) :
		$pn = 1;
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
		$ret .= '<button class="loadmore slotoload">'.__( 'Load more', 'jgambling' ).'</button>';
	endif;
	echo $ret;
	die();

}


add_action( 'wp_ajax_search_slots', 'search_slots' );
add_action( 'wp_ajax_nopriv_search_slots', 'search_slots' );