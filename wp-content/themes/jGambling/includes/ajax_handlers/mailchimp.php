<?php
function subscribe_singular() {
	$authToken = carbon_get_theme_option( 'api_key' );
	$postData  = array(
		"email_address" => strip_tags( $_POST['postmail'] ),
		"status"        => "subscribed",
		"merge_fields"  => array(
			"NAME"  => "SUB FROM SITE",
			"PHONE" => "+123"
		)
	);
	$listID    = carbon_get_theme_option( 'list_id' );

	$ch = curl_init( 'https://us' . carbon_get_theme_option( 'api_num' ) . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' );
	curl_setopt_array( $ch, array(
		CURLOPT_POST           => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER     => array(
			'Authorization: apikey ' . $authToken,
			'Content-Type: application/json'
		),
		CURLOPT_POSTFIELDS     => json_encode( $postData )
	) );
	$response = curl_exec( $ch );
	$res      = json_decode( $response );

	if ( $res->id ) {
		echo '1';
	} else {
		print_r( $res );
	}
	die();

}

add_action( 'wp_ajax_subscribe_mailchimp', 'subscribe_singular' );
add_action( 'wp_ajax_nopriv_subscribe_mailchimp', 'subscribe_singular' );