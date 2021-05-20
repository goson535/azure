<?
$image_att = carbon_get_post_meta( get_the_ID(), 'slot_img_grid' );
if ( $image_att ) {
	$image_src = aq_resize( wp_get_attachment_image_url( $image_att, 'full' ), 165, 245, true, true, true );
}
$soft_term = wp_get_post_terms( get_the_ID(), 'software', array( 'fields' => 'all' ) );
if ( $soft_term ):
	$first_soft      = $soft_term[0]->name;
	$first_soft_link = get_term_link( $soft_term[0]->term_id, 'software' );
endif;
?>
<div class="item">
    <img src="<?php echo $image_src ?>">
    <div class="content">
		<?php if ( $soft_term ): ?>
            <div class="b1"><a href="<?php echo $first_soft_link; ?>"><?php echo $first_soft; ?></a></div>
		<?php endif; ?>
        <div class="b2"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
        <a href="<?php echo get_the_permalink(); ?>" class="play_slot"></a>
    </div>
</div>