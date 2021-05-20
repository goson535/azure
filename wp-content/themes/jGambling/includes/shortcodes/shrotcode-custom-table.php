<?php
function shortcode_custom_table( $atts ) {
	extract( shortcode_atts( array(
		'list'       => "",
		'bonus'      => "welcome",
		'device_col' => "",
		'tc'         => 1
	), $atts ) );
	$ret = '';
	/*welcome */
	$b_static = carbon_get_theme_option( 'table' );

	$b_hover = carbon_get_theme_option( 'table_hover' );
	if ( $b_static || $b_hover ) {
		$ret .= "<style>";
		if ( $b_static ) {
			$ret .= 'table a.play{background: ' . $b_static . '! important;}';
		}
		if ( $b_hover ) {
			$ret .= 'table a.play:hover{background: ' . $b_hover . '! important;}';
		}
		$ret .= "</style>";
	}


	$ret .= '<div class="index-rating"><table><thead><tr><td class="pos">#</td><td>' . __( 'Online casino', 'jgambling' ) . '</td><td>' . __( 'Casino rating', 'jgambling' ) . '</td>';
	if ( $bonus == 'welcome' ):
		$ret .= '<td>' . __( 'Welcome', 'jgambling' ) . '</td >';
	elseif ( $bonus == 'no-deposit' ):
		$ret .= '<td>' . __( 'No-deposit bonus', 'jgambling' ) . '</td >';
	elseif ( $bonus == 'freespins' ):
		$ret .= '<td>' . __( 'Free-spins', 'jgambling' ) . '</td >';
	elseif ( $bonus == 'reload' ):
		$ret .= '<td>' . __( 'Reload bonus', 'jgambling' ) . '</td >';
	elseif ( $bonus == 'cashback' ):
		$ret .= '<td>' . __( 'Cashback bonus', 'jgambling' ) . '</td >';
	endif;
	$ret .= '<td>' . __( 'No-deposit', 'jgambling' ) . '</td>';

	if ( $device_col != 'false' ):
		$ret .= '<td>' . __( 'Devices', 'jgambling' ) . '</td>';
	endif;

	if ( $custom_col_title ):
		$ret .= '<td>' . $custom_col_title . '</td>';
	endif;

	$ret .= '<td></td>';
	$ret .= '</tr></thead><tbody>';


	if ( $list ) {
		$position = 1;
		$arr      = explode( ',', $list );
		foreach ( $arr as $item ) :
			$image_att       = carbon_get_post_meta( $item, 'img_table' );
			$image_rounded   = aq_resize( wp_get_attachment_url( $image_att ), 40, 40, true, true, true );
			$rating_ceil     = ceil( carbon_get_post_meta( $item, 'rating' ) );
			$has_no_deposit  = carbon_get_post_meta( $item, 'no_deposit' );
			$has_aval_pc     = carbon_get_post_meta( $item, 'aval_pc' );
			$has_aval_tablet = carbon_get_post_meta( $item, 'aval_tablet' );
			$has_aval_phone  = carbon_get_post_meta( $item, 'aval_phone' );
			$ref             = carbon_get_post_meta( $item, 'ref' );
			$custom_col      = carbon_get_post_meta( $item, 'custom_col' );

			$welcome_bonus        = carbon_get_post_meta( $item, 'welcome' ) ? carbon_get_post_meta( $item, 'welcome' ) : 'n/a';
			$welcome_bonus_desc   = carbon_get_post_meta( $item, 'welcome_desc' );
			$nodep_bonus          = carbon_get_post_meta( $item, 'no_deposit' ) ? carbon_get_post_meta( $item, 'no_deposit' ) : "n/a";
			$nodep_bonus_desc     = carbon_get_post_meta( $item, 'no_deposit_desc' );
			$reload_bonus         = carbon_get_post_meta( $item, 'reload' ) ? carbon_get_post_meta( $item, 'reload' ) : 'n/a';
			$reload_bonus_desc    = carbon_get_post_meta( $item, 'reload_desc' );
			$cashback_bonus       = carbon_get_post_meta( $item, 'cashback' ) ? carbon_get_post_meta( $item, 'cashback' ) : 'n/a';
			$cashback_bonus_desc  = carbon_get_post_meta( $item, 'cashback_desc' );
			$freespins_bonus      = carbon_get_post_meta( $item, 'freespins' ) ? carbon_get_post_meta( $item, 'freespins' ) : 'n/a';
			$freespins_bonus_desc = carbon_get_post_meta( $item, 'freespins_desc' );
			$ret                  .= '<tr>
                        <td  class="pos">' . $position ++ . '.</td>
                        <td>
                            <div class="name"><a href="' . get_the_permalink( $item ) . '"><img class="lazy logo_img" alt="' . get_the_title( $item ) . '" data-src="' . $image_rounded . '">' . get_the_title( $item ) . '</a></div>
                        </td>
                        <td>' . draw_rating( $rating_ceil ) . '</td>';


			if ( $bonus == 'welcome' ):
				$ret .= '<td class="bonus_tac">' . $welcome_bonus;
				if ( $welcome_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Welcome', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $welcome_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'no-deposit' ):
				$ret .= '<td class="bonus_tac">' . $nodep_bonus;
				if ( $nodep_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'No-deposit bonus', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $nodep_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';

			elseif ( $bonus == 'freespins' ):
				$ret .= '<td class="bonus_tac">' . $freespins_bonus;
				if ( $freespins_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Free-spins', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $freespins_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'reload' ):
				$ret .= '<td class="bonus_tac">' . $reload_bonus;
				if ( $reload_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Reload bonus', 'jgambling' ) . '"  data-placement="bottom" data-content="' . htmlentities( $reload_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'cashback' ):
				$ret .= '<td class="bonus_tac">' . $cashback_bonus;
				if ( $cashback_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Cashback bonus', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $cashback_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';
			endif;


			$ret .= '<td>';
			if ( $has_no_deposit ):
				$ret .= '<img class="tac_span_no_deposit" data-title="' . $nodep_bonus . '"  data-placement="bottom"  data-content="' . htmlentities( $nodep_bonus_desc ) . '" class="lazy bonus_icon" data-src="' . get_template_directory_uri() . '/assets/img/svg/checked.svg" alt="deposit bonus" >';
			else:
				$ret .= '<img class="lazy bonus_icon" data-src="' . get_template_directory_uri() . '/assets/img/svg/nochecked.svg" alt="no deposit bonus" >';
			endif;
			$ret .= '</td>';


			if ( $device_col != 'false' ):
				$ret .= '<td>
				<div class="devices">';
				if ( $has_aval_pc ):
					$ret .= '<img class="lazy device_icon" data-src = "' . get_template_directory_uri() . '/assets/img/svg/computer.svg" alt="PC">';
				endif;
				if ( $has_aval_tablet ):
					$ret .= '<img class="lazy device_icon" data-src = "' . get_template_directory_uri() . '/assets/img/svg/tablet.svg"  alt="Tablet">';
				endif;
				if ( $has_aval_phone ):
					$ret .= '<img class="lazy device_icon" data-src = "' . get_template_directory_uri() . '/assets/img/svg/smartphone.svg"  alt="Phone">';
				endif;

				$ret .= '</div></td>';
			endif;

			if ( $custom_col_title ):
				$ret .= '<td>' . $custom_col . '</td>';
			endif;

			$ret .= '<td>
                            <a class="play" rel="nofollow" href="' . $ref . '" target="_blank">' . __( 'Play now', 'jgambling' ) . '</a>
                        </td>
                    </tr>';
		endforeach;

	} else {
		return '<span style="color: red;">' . __( 'No casino reviews found', 'jgambling' ) . '</span>';
	}

	$ret .= '</tbody></table></div>';

	return $ret;
}


add_shortcode( 'custom_table', 'shortcode_custom_table' );