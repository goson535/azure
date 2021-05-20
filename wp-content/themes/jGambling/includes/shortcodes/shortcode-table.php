<?php
function shortcode_table( $atts ) {
	extract( shortcode_atts( array(
		'num'              => 10,
		'bonus'            => 'welcome',
		'orderby'          => 'meta_value_num',
		'order'            => 'DESC',
		'deposit'          => "",
		'currency'         => "",
		'cashout'          => "",
		'soft'             => "",
		'restricted'       => "",
		'casino_type'      => "",
		'license'          => "",
		'list'             => "",
		'device_col'       => "",
		'geo'              => 0,
		'custom_col_title' => "",
		'tc'               => ""
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


	if ( $geo ) {
		$ret .= '<td><div class="tool-tip">
            <i class="tool-tip__icon">?</i>
            <p class="tool-tip__info">
            ' . __( 'The list of casinos allowed in', 'jgambling' ) . ' ' . get_full_country() . ' 
            </p>
          </div></td>';
	} else {
		$ret .= '<td></td>';
	}
	$ret .= '</tr></thead><tbody>';
	wp_reset_query();
	$args = array(
		'post_type'      => 'casino',
		'posts_per_page' => $num,
		'order'          => $order,
		'orderby' => $orderby,
	);
	if ( $orderby == 'meta_value_num' ) {
		$args['meta_key'] = '_rating';
	}

	if ( $deposit ) {
		$add_tax = array(
			'taxonomy' => 'deposit',
			'field'    => 'slug',
			'terms'    => $deposit
		);
	}

	if ( $currency ) {
		$add_tax = array(
			'taxonomy' => 'currency',
			'field'    => 'slug',
			'terms'    => $currency
		);
	}

	if ( $cashout ) {
		$add_tax = array(
			'taxonomy' => 'cashout',
			'field'    => 'slug',
			'terms'    => $cashout
		);
	}

	if ( $restricted ) {
		$add_tax = array(
			'taxonomy' => 'restricted',
			'field'    => 'slug',
			'terms'    => $restricted
		);
	}

	if ( $soft ) {
		$add_tax = array(
			'taxonomy' => 'soft',
			'field'    => 'slug',
			'terms'    => $soft
		);
	}

	if ( $license ) {
		$add_tax = array(
			'taxonomy' => 'license',
			'field'    => 'slug',
			'terms'    => $license
		);
	}

	if ( $casino_type ) {
		$add_tax = array(
			'taxonomy' => 'casino_type',
			'field'    => 'slug',
			'terms'    => $casino_type
		);
	}

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
	$args['tax_query'][] = $add_tax;
	$query               = new WP_Query( $args );

	if ( $query->have_posts() ) {
		$position = 1;
		while ( $query->have_posts() ):
			$query->the_post();
			$image_att       = carbon_get_post_meta( get_the_ID(), 'img_table' );
			$image_rounded   = aq_resize( wp_get_attachment_url( $image_att ), 40, 40, true, true, true );
			$rating_ceil     = ceil( carbon_get_post_meta( get_the_ID(), 'rating' ) );
			$has_no_deposit  = carbon_get_post_meta( get_the_ID(), 'no_deposit' );
			$has_aval_pc     = carbon_get_post_meta( get_the_ID(), 'aval_pc' );
			$has_aval_tablet = carbon_get_post_meta( get_the_ID(), 'aval_tablet' );
			$has_aval_phone  = carbon_get_post_meta( get_the_ID(), 'aval_phone' );
			$ref             = carbon_get_post_meta( get_the_ID(), 'ref' );
			$custom_col      = carbon_get_post_meta( get_the_ID(), 'custom_col' );

			$welcome_bonus        = carbon_get_post_meta( get_the_ID(), 'welcome' ) ? carbon_get_post_meta( get_the_ID(), 'welcome' ) : 'n/a';
			$welcome_bonus_desc   = carbon_get_post_meta( get_the_ID(), 'welcome_desc' );
			$nodep_bonus          = carbon_get_post_meta( get_the_ID(), 'no_deposit' ) ? carbon_get_post_meta( get_the_ID(), 'no_deposit' ) : "n/a";
			$nodep_bonus_desc     = carbon_get_post_meta( get_the_ID(), 'no_deposit_desc' );
			$reload_bonus         = carbon_get_post_meta( get_the_ID(), 'reload' ) ? carbon_get_post_meta( get_the_ID(), 'reload' ) : 'n/a';
			$reload_bonus_desc    = carbon_get_post_meta( get_the_ID(), 'reload_desc' );
			$cashback_bonus       = carbon_get_post_meta( get_the_ID(), 'cashback' ) ? carbon_get_post_meta( get_the_ID(), 'cashback' ) : 'n/a';
			$cashback_bonus_desc  = carbon_get_post_meta( get_the_ID(), 'cashback_desc' );
			$freespins_bonus      = carbon_get_post_meta( get_the_ID(), 'freespins' ) ? carbon_get_post_meta( get_the_ID(), 'freespins' ) : 'n/a';
			$freespins_bonus_desc = carbon_get_post_meta( get_the_ID(), 'freespins_desc' );
			$ret                  .= '<tr>
                        <td  class="pos">' . $position ++ . '.</td>
                        <td>
                            <div class="name"><a href="' . get_the_permalink() . '"><img class="lazy logo_img" alt="' . get_the_title() . '" data-src="' . $image_rounded . '">' . get_the_title() . '</a></div>
                        </td>
                        <td>' . draw_rating( $rating_ceil ) . '</td>';


			if ( $bonus == 'welcome' ):
				$ret .= '<td>' . $welcome_bonus;
				if ( $welcome_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Welcome', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $welcome_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'no-deposit' ):
				$ret .= '<td>' . $nodep_bonus;
				if ( $nodep_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'No-deposit bonus', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $nodep_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';

			elseif ( $bonus == 'freespins' ):
				$ret .= '<td>' . $freespins_bonus;
				if ( $freespins_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Free-spins', 'jgambling' ) . '"  data-placement="bottom"  data-content="' . htmlentities( $freespins_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'reload' ):
				$ret .= '<td>' . $reload_bonus;
				if ( $reload_bonus_desc AND $tc == 1 ) {
					$ret .= '<span class="tac_span" data-title="' . __( 'Reload bonus', 'jgambling' ) . '"  data-placement="bottom" data-content="' . htmlentities( $reload_bonus_desc ) . '">' . __( 'T&C Apply', 'jgambling' ) . '</span>';
				}
				$ret .= '</td>';


			elseif ( $bonus == 'cashback' ):
				$ret .= '<td>' . $cashback_bonus;
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
		endwhile;

	} else {
		return '<span style="color: red;">' . __( 'No casino reviews found', 'jgambling' ) . '</span>';
	}

	$ret .= '</tbody></table></div>';

	return $ret;
}


add_shortcode( 'table', 'shortcode_table' );