<?php
function shortcode_custom_bonus( $atts ) {
	extract( shortcode_atts( array(
		'list' => "",
	), $atts ) );
	$ret = '';
	/*welcome */


	$ret .= '<div class="bonus-list "><div class="flex2">';


	if ( $list ) {
		$list_arr = explode( ',', $list );
		foreach ( $list_arr as $item ):
			$bonus_title     = get_the_title( $item );
			$permalink       = get_the_permalink( $item );
			$casino          = carbon_get_post_meta( $item, 'cas' )[0]['id'];
			$casino_logo_att = carbon_get_post_meta( $casino, 'img_single' );
			$casino_logo_src = aq_resize( wp_get_attachment_url( $casino_logo_att ), 282, 116, true, true, true );
			$casino_ref      = carbon_get_post_meta( $casino, 'ref' );
			$casino_desc     = carbon_get_post_meta( $item, 'descr' );
			$summa           = carbon_get_post_meta( $item, 'summa' );
			$bcode           = carbon_get_post_meta( $item, 'bcode' );
			if ( ! $bcode ) {
				$bcode = 'n/a';
			}
			if ( $casino ) {
				$casino_rating = carbon_get_post_meta( $casino, 'rating' );

			}
			$type_term = get_the_terms( $item, 'type' );
			if ( $type_term ) {
				$type_term_first = $type_term[0]->name;
				$type_term_link  = get_term_link( $type_term[0]->term_id, 'type' );
			}
			$ret .= '<div class="item">';
			if ( $type_term ) {
				$ret .= '<div class="b1 upper"><a href="' . $type_term_link . '">' . $type_term_first . '</a></div>';
			}

			$ret .= '<div class="name">' . $bonus_title . '</div>';
			if ( carbon_get_theme_option( 'show_bonus_casino_img' ) ) :
				$ret .= '<div class="bonus_img">
            <img src="' . $casino_logo_src . '" alt="' . $bonus_title . '">
        </div>';
			endif;
			$ret .= '<div class="rating">' . draw_rating( $casino_rating ) . '</div>
										    <div class="price">' . $summa . '</div>
										    <div class="code">' . $bcode . '</div>
										    <p>' . $casino_desc . '</p>
										    <div class="flex">
										        <a class="b1" href="' . $permalink . '">' . __( 'More', 'jgambling' ) . '</a>
										        <a class="b2" href="' . $casino_ref . '">' . __( 'Get bonus', 'jgambling' ) . '</a>
										    </div>
										</div>';
		endforeach;

	} else {
		return '<span style="color: red;">' . __( 'Parameter LIST is required', 'jgambling' ) . '</span>';
	}

	$ret .= '</div></div>';

	return $ret;
}


add_shortcode( 'custom_bonuses', 'shortcode_custom_bonus' );