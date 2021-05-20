<?php

$image_grid_att = carbon_get_post_meta( get_the_ID(), 'img_grid' );
$image_grid_src = wp_get_attachment_url( $image_grid_att );
$rating_ceil    = ceil( carbon_get_post_meta( get_the_ID(), 'rating' ) );
$has_no_deposit = carbon_get_post_meta( get_the_ID(), 'no_deposit' );
$has_welcome    = carbon_get_post_meta( get_the_ID(), 'welcome' );
$ref            = carbon_get_post_meta( get_the_ID(), 'ref' );
$casino_title   = get_the_title();
$permalink      = get_the_permalink();
$ret            .= '<div class="item">
                        <div class="logo">
                            <a href="' . $permalink . '"><img src="' . $image_grid_src . '"></a>
                        </div>
                        ' . draw_rating( $rating_ceil ) . '
                        <div class="content">
                            <p>' . $casino_title . '</p>
                            <div class="info">
                                <span>' . __( 'No deposit bonus', 'jgambling' ) . '</span>';
if ( $has_no_deposit ):
	$ret .= $has_no_deposit;
else:
	$ret .= 'n/a';
endif;
$ret .= '</div>
													                            <div class="info">
													                                <span>' . __( 'Welcome bonus', 'jgambling' ) . '</span>';
if ( $has_welcome ):
	$ret .= $has_welcome;
else:
	$ret .= 'n/a';
endif;
$ret .= '</div>';
if ( get_full_country() AND  get_full_country_flag() ) {


	if ( has_term( get_full_country(), 'restricted' ) ) {
		$img = "not_allow.svg";
	} else {
		$img = "allow.svg";
	}
	$ret .= '<div class="grid_country">
								<img class="country_access"  src="' . get_template_directory_uri() . '/assets/img/svg/' . $img . '" alt="">
								<img class="country_mini" src="' . get_full_country_flag() . '" alt="">
								<span>'.__('Players from','jgambling').' ' . get_full_country() . '</span>
								</div>';
}
$ret .= '<a href="' . $ref . '" class="play" rel="nofollow" target="_blank">' . __( 'Play casino', 'jgambling' ) . '</a>
                            <a href="' . $permalink . '">' . __( 'Review', 'jgambling' ) . '</a>
                        </div>
                    </div>';

echo $ret;