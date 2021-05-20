<?

function shortcode_custom_terms( $atts ) {
	extract( shortcode_atts( array(
		'tax' => '',
	), $atts ) );

	$ret = '';
	if ( $tax ) {
		$terms = get_terms( $tax, [
			'hide_empty' => true,
		] );
		if ( $terms ) {
			$ret .= '<div class="tax_archive_wrap">';
			foreach ( $terms as $item ) {
				$term_big_img_att = carbon_get_term_meta( $item->term_id, 'big_img' );
				$term_big_img_src = wp_get_attachment_url( $term_big_img_att );
				$ret              .= '<div class="tax_archive_item">';
				$ret              .= '<div class="item_img">';
				$ret              .= '<a href="' . get_term_link( $item->term_id, $tax ) . '"><img src="' . aq_resize( $term_big_img_src, 195, 127, true, true, true ) . '" alt=""></a>';
				$ret              .= '</div>';
				$ret              .= '<div class="item_title"><a href="' . get_term_link( $item->term_id, $tax ) . '">' . $item->name . '</a> - <span>' . $item->count . ' казино</span></div>';
				$ret              .= '</div>';

			}
			$ret .= ' </div > ';
		}
	} else {
		return __( 'Parameter tax - required', 'jgambling' );
	}
	wp_reset_query();


	return $ret;
}


add_shortcode( 'custom-terms', 'shortcode_custom_terms' );