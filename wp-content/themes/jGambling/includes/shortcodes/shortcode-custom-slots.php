<?php
function shortcode_custom_slots( $atts ) {
	extract( shortcode_atts( array(
		'list' => "",
	), $atts ) );
	$ret = '';
	/*welcome */


	$ret .= '<div class="slots small"><div class="flex2">';


	if ( $list ) {
		$list_arr = explode( ',', $list );
		foreach ( $list_arr as $item ):
			$image_att = carbon_get_post_meta( $item, 'slot_img_grid' );
			if ( $image_att ) {
				$image_src = aq_resize( wp_get_attachment_image_url( $image_att, 'full' ), 165, 245, true, true, true );
			}
			$soft_term = wp_get_post_terms( $item, 'software', array( 'fields' => 'all' ) );
			if ( $soft_term ) {
				$first_soft      = $soft_term[0]->name;
				$first_soft_link = get_term_link( $soft_term[0]->term_id, 'software' );
			}

			$ret .= '<div class="item">
    <img alt="' . get_the_title( $item ) . '" class="lazy" data-src="' . $image_src . '">
    <div class="content">';
			if ( $soft_term ):
				$ret .= '<div class="b1"><a href="' . $first_soft_link . '">' . $first_soft . '</a></div>';
			endif;
			$ret .= '<div class="b2"><a href="' . get_the_permalink( $item ) . '">' . get_the_title( $item ) . '</a></div>
        <a href="' . get_the_permalink( $item ) . '" class="play_slot"></a>
    </div>
</div>';
		endforeach;

	} else {
		return '<span style="color: red;">' . __( 'Parameter LIST is required', 'jgambling' ) . '</span>';
	}

	$ret .= '</div></div>';

	return $ret;
}


add_shortcode( 'custom_slots', 'shortcode_custom_slots' );