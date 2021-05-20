<?php
$bonus_title = get_the_title();
$permalink   = get_the_permalink();
$casino_arr  = carbon_get_post_meta( get_the_ID(), 'cas' );
if ( $casino_arr ) {
	$casino          = $casino_arr[0]['id'];
	$casino_ref      = carbon_get_post_meta( $casino, 'ref' );
	$casino_logo_att = carbon_get_post_meta( $casino, 'img_single' );
	$casino_logo_src = aq_resize( wp_get_attachment_url( $casino_logo_att ), 282, 116, true, true, true );
}
$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
$bcode       = carbon_get_post_meta( get_the_ID(), 'bcode' );
if ( ! $bcode ) {
	$bcode = 'n/a';
}
$wager = carbon_get_post_meta( get_the_ID(), 'wager' );
if ( $casino ) {
	$casino_rating = carbon_get_post_meta( $casino, 'rating' );

}
$type_term = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'all' ) );
if ( $type_term ) {
	$type_term_first = $type_term[0]->name;
	$type_term_link  = get_term_link( $type_term[0]->term_id, 'type' );
}
?>
<div class="item">
	<?php if ( $type_term ): ?>
        <div class="b1 upper"><a href="<?php echo $type_term_link; ?>"><?php echo $type_term_first; ?></a></div>
	<?php endif; ?>
    <div class="name"><?php echo $bonus_title ?></div>
	<?php if ( carbon_get_theme_option( 'show_bonus_casino_img' ) ) : ?>
        <div class="bonus_img">
            <img src="<?php echo $casino_logo_src; ?>" alt="<?php echo $bonus_title ?>">
        </div>
	<?php endif; ?>
    <div class="rating">
		<?php echo draw_rating( $casino_rating ) ?>
    </div>
    <div class="price"><?php echo $summa; ?></div>
    <div class="code"><?php echo $bcode; ?></div>
    <p class="bonus_desc"><?php echo $casino_desc; ?></p>
    <div class="flex">
        <a class="b1" href="<?php echo $permalink; ?>"><?php echo __( 'More', 'jgambling' ); ?></a>
        <a class="b2" href="<?php echo $casino_ref; ?>"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
    </div>
</div>