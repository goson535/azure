<?php
function shortcode_single_casino( $atts ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );
	$ret = '';

	if ( $id ) {
		$rating       = number_format( carbon_get_post_meta( $id, 'rating' ), 1 );
		$logo_att     = carbon_get_post_meta( $id, 'img_single' );
		$logo_src     = aq_resize( wp_get_attachment_url( $logo_att ), 194, 108, true, true, true );
		$content_post = get_post( $id );
		$content      = $content_post->post_content;
		$small        = strip_tags(mb_substr( $content, 0, 100 ));
		$ret .= '<div class="slot-info">
                    <div class="image">
                        <img src="' . $logo_src . '">
                    </div>
                    <div class="info"> 
                        <div class="flex">
                            <div style="display: flex">
                                <div class="rating">
                                    <span>' . $rating . '</span> / 5
                                    ' . draw_single_rating( $rating ) . ' 
                                    <div class="items">' . wp_count_comments( $id )->approved . ' ' . __( 'reviews', 'jgambling' ) . '</div>
                                </div>
                                <div class="name">
                                    <span>№' . get_casino_position( $id ) . ' ' . __( 'in casino rating', 'jgambling' ) . ' </span><br>
                                    ' . get_the_title( $id ) . '
                                </div>
                            </div>
                            <noindex><a href="' . carbon_get_post_meta( $id, 'ref' ) . '" class="play" rel="nofollow">' . __( 'Play now', 'jgambling' ) . '</a></noindex>
                        </div>
                        <div class="text">' . $small . '...</div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>';
	} else {
		$ret .= '<h2 style="color: red;">' . __( 'Enter ID attribute', 'jgambling' ) . '</h2>';
	}

	return $ret;
}


add_shortcode( 'single', 'shortcode_single_casino' );