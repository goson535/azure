<?php
function load_reviews() {
	$count_needed = carbon_get_theme_option('comment_count');
	$args         = array(
		'post_id' => $_POST['post'],
		'number'  => $count_needed,
		'status'=>'approve',
		'offset'  => ( $_POST['page'] * carbon_get_theme_option('comment_count')  )
	);
	$comments     = get_comments( $args );
	$ret          = '';
	foreach ( $comments as $comment ) {
		$plus   = carbon_get_comment_meta( $comment->comment_ID, 'plus' );
		$minus  = carbon_get_comment_meta( $comment->comment_ID, 'minus' );
		$rating = carbon_get_comment_meta( $comment->comment_ID, 'rating' );

		$ret .= '<div class="item ">
	<div class="avatar">
		<img src="' . get_template_directory_uri() . '/assets/img/svg/user.svg">
		<div>' . $comment->comment_author . '</div>
	</div>
	<div class="content">
		<div class="date">'.__( 'Published', 'jgambling' ).' ' . date( 'd F', strtotime( $comment->comment_date ) ) . '</div>';
		 $ret.=draw_rating( $rating );
		if ( $plus ):
			$ret .= '<p><img src="' . get_template_directory_uri() . '/assets/img/svg/plus.svg">' . $plus . '</p>';
		endif;
		if ( $minus ):
			$ret .= '<p><img src="' . get_template_directory_uri() . '/assets/img/svg/minus.svg">' . $minus . '</p>';
		endif;

		$ret .= '</div><div class="clear"></div></div>';
	}
	echo $ret;
	die();
}

add_action( 'wp_ajax_load_reviews', 'load_reviews' );
add_action( 'wp_ajax_nopriv_load_reviews', 'load_reviews' );