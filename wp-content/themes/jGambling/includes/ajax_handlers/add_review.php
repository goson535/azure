<?php
function add_review() {
	$post_id      = $_POST['post'];
	$plus         = $_POST['plus'];
	$minus        = $_POST['minus'];
	$email        = $_POST['email'];
	$name         = $_POST['name'];
	$rating       = $_POST['rating'];
	$ret          = 0;
	$temp_content = "Plus: " . $plus . " Minus: " . $minus . "";

	if ( $post_id ) {
		$data = array(
			'comment_post_ID'      => $post_id,
			'comment_author'       => $name,
			'comment_author_email' => $email,
			'comment_content'      => $temp_content,
			'comment_type'         => '',
			'comment_parent'       => 0,
			'comment_author_IP'    => '127.0.0.1',
			'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
			'comment_approved'     => 0,
		);
		$res  = wp_insert_comment( wp_slash( $data ) );
		if ( $res ) {
			if ( $plus ) {
				update_comment_meta( $res, '_plus', $plus );
			}
			if ( $minus ) {
				update_comment_meta( $res, '_minus', $minus );
			}
			update_comment_meta( $res, '_rating', $rating );
			$ret = '1';
		}
		echo $ret;
		die();
	}
}

add_action( 'wp_ajax_add_reviews', 'add_review' );
add_action( 'wp_ajax_nopriv_add_reviews', 'add_review' );