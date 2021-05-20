<?php
$post_id = get_the_ID();
$rating  = carbon_get_post_meta( $post_id, 'rating' );
$ref     = carbon_get_post_meta( $post_id, 'ref' );
if ( carbon_get_post_meta( $post_id, 'welcome_ref' ) ) {
	$welcome_ref = carbon_get_post_meta( $post_id, 'welcome_ref' );
} else {
	$welcome_ref = carbon_get_post_meta( $post_id, 'ref' );
}

if ( carbon_get_post_meta( $post_id, 'freespins_ref' ) ) {
	$freespins_ref = carbon_get_post_meta( $post_id, 'freespins_ref' );
} else {
	$freespins_ref = carbon_get_post_meta( $post_id, 'ref' );
}

if ( carbon_get_post_meta( $post_id, 'no_deposit_ref' ) ) {
	$no_deposit_ref = carbon_get_post_meta( $post_id, 'no_deposit_ref' );
} else {
	$no_deposit_ref = carbon_get_post_meta( $post_id, 'ref' );
}

if ( carbon_get_post_meta( $post_id, 'reload_ref' ) ) {
	$reload_ref = carbon_get_post_meta( $post_id, 'reload_ref' );
} else {
	$reload_ref = carbon_get_post_meta( $post_id, 'ref' );
}


if ( carbon_get_post_meta( $post_id, 'cashback_ref' ) ) {
	$cashback_ref = carbon_get_post_meta( $post_id, 'cashback_ref' );
} else {
	$cashback_ref = carbon_get_post_meta( $post_id, 'ref' );
}


$ref_text    = carbon_get_post_meta( $post_id, 'ref_text' );
$ceil_rating = ceil( $rating );
$logo_att    = carbon_get_post_meta( $post_id, 'img_single' );
$logo_src    = aq_resize( wp_get_attachment_url( $logo_att ), 194, 108, true, true, true );
if ( carbon_get_post_meta( $post_id, 'custom_h1' ) ) {
	$h1 = carbon_get_post_meta( $post_id, 'custom_h1' );
} else {
	$h1 = get_the_title();
}

/*Bonuses*/
$welcome         = carbon_get_post_meta( $post_id, 'welcome' );
$welcome_desc    = carbon_get_post_meta( $post_id, 'welcome_desc' );
$no_deposit      = carbon_get_post_meta( $post_id, 'no_deposit' );
$no_deposit_desc = carbon_get_post_meta( $post_id, 'no_deposit_desc' );
$reload          = carbon_get_post_meta( $post_id, 'reload' );
$reload_desc     = carbon_get_post_meta( $post_id, 'reload_desc' );
$freespins       = carbon_get_post_meta( $post_id, 'freespins' );
$freespins_desc  = carbon_get_post_meta( $post_id, 'freespins_desc' );
$cashback        = carbon_get_post_meta( $post_id, 'cashback' );
$cashback_desc   = carbon_get_post_meta( $post_id, 'cashback_desc' );


$color_welcome    = carbon_get_theme_option( 'color-welcome' );
$color_no_deposit = carbon_get_theme_option( 'color-no-deposit' );
$color_reload     = carbon_get_theme_option( 'color-reload' );
$color_freespins  = carbon_get_theme_option( 'color-freespins' );
$color_cashback   = carbon_get_theme_option( 'color-cashback' );

wp_reset_query();
$nd_tax_arr = carbon_get_theme_option( 'nd_tax' );
if ( $nd_tax_arr ):
	$nd_tax = $nd_tax_arr[0]['id'];
	wp_reset_query();
	$args = array(
		'post_type'      => 'bonus',
		'posts_per_page' => - 1,
		'meta_query'     => [
			[
				'key'   => '_cas|||0|id',
				'value' => get_the_ID()
			],
		],
		'tax_query'      => [
			[
				'taxonomy' => 'type',
				'field'    => 'id',
				'terms'    => array( $nd_tax ),
			],

		]
	);
	$q    = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
			$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
			if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
				$ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
			} else {
				$ref = carbon_get_post_meta( $post_id, 'ref' );
			}
			?>
            <div class="bonus">
                <div class="name color2" <?php if ( $color_no_deposit ): echo "style='background-color:" . $color_no_deposit . ";'"; endif; ?>>
					<?php echo __( 'NO DEPOSIT BONUS', 'jgambling' ); ?>
                    <span><?php echo $summa; ?></span>
                </div>
                <div class="content">
					<?php echo $casino_desc; ?>
                    <a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
                       target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
                </div>
            </div>
		<? endwhile;
	endif;
endif;


wp_reset_query();
$fs_tax_arr = carbon_get_theme_option( 'fs_tax' );
if ( $fs_tax_arr ):
	$fs_tax = $fs_tax_arr[0]['id'];
	wp_reset_query();
	$args = array(
		'post_type'      => 'bonus',
		'posts_per_page' => - 1,
		'meta_query'     => [
			[
				'key'   => '_cas|||0|id',
				'value' => get_the_ID()
			],
		],
		'tax_query'      => [
			[
				'taxonomy' => 'type',
				'field'    => 'id',
				'terms'    => array( $fs_tax ),
			],
		]
	);
	$q    = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
			$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
			if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
				$ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
			} else {
				$ref = carbon_get_post_meta( $post_id, 'ref' );
			}
			?>
            <div class="bonus">
                <div class="name color4" <?php if ( $color_freespins ): echo "style='background-color:" . $color_freespins . ";'"; endif; ?>>
					<?php echo __( 'FREESPINS', 'jgambling' ); ?>
                    <span><?php echo $summa; ?></span>
                </div>
                <div class="content">
					<?php echo $casino_desc; ?>
                    <a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
                       target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
                </div>
            </div>
		<? endwhile;
	endif;
endif;


$w_tax_arr = carbon_get_theme_option( 'w_tax' );
if ( $w_tax_arr ):
	$w_tax = $w_tax_arr[0]['id'];
	wp_reset_query();
	$args = array(
		'post_type'      => 'bonus',
		'posts_per_page' => - 1,
		'meta_query'     => [
			[
				'key'   => '_cas|||0|id',
				'value' => get_the_ID()
			],
		],
		'tax_query'      => [
			[
				'taxonomy' => 'type',
				'field'    => 'id',
				'terms'    => array( $w_tax ),
			],
		]
	);
	$q    = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
			$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
			if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
				$ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
			} else {
				$ref = carbon_get_post_meta( $post_id, 'ref' );
			}
			?>
            <div class="bonus">
                <div class="name color1" <?php if ( $color_welcome ): echo "style='background-color:" . $color_welcome . ";'"; endif; ?>>
					<?php echo __( 'WELCOME BONUS', 'jgambling' ); ?>
                    <span><?php echo $summa; ?></span>
                </div>
                <div class="content">
					<?php echo $casino_desc ?>
                    <a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
                       target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
                </div>
            </div>
		<? endwhile;
	endif;
endif;


$reload_tax_arr = carbon_get_theme_option( 'r_tax' );
if ( $reload_tax_arr ):
	$reload_tax = $reload_tax_arr[0]['id'];
	wp_reset_query();
	$args = array(
		'post_type'      => 'bonus',
		'posts_per_page' => - 1,
		'meta_query'     => [
			[
				'key'   => '_cas|||0|id',
				'value' => get_the_ID()
			],
		],
		'tax_query'      => [
			[
				'taxonomy' => 'type',
				'field'    => 'id',
				'terms'    => array( $reload_tax ),
			],
		]
	);
	$q    = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
			$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
			if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
				$ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
			} else {
				$ref = carbon_get_post_meta( $post_id, 'ref' );
			}
			?>
            <div class="bonus">
                <div class="name color3" <?php if ( $color_reload ): echo "style='background-color:" . $color_reload . ";'"; endif; ?>>
					<?php echo __( 'RELOAD BONUS', 'jgambling' ); ?>
                    <span><?php echo $summa; ?></span>
                </div>
                <div class="content">
					<?php echo $casino_desc; ?>
                    <a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
                       target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
                </div>
            </div>
		<? endwhile;
	endif;
endif;


$cashback_tax_arr = carbon_get_theme_option( 'c_tax' );
if ( $cashback_tax_arr ):
	$cashback_tax = $cashback_tax_arr[0]['id'];
	wp_reset_query();
	$args = array(
		'post_type'      => 'bonus',
		'posts_per_page' => - 1,
		'meta_query'     => [
			[
				'key'   => '_cas|||0|id',
				'value' => get_the_ID()
			],
		],
		'tax_query'      => [
			[
				'taxonomy' => 'type',
				'field'    => 'id',
				'terms'    => array( $cashback_tax ),
			],
		]
	);
	$q    = new WP_Query( $args );
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$casino_desc = carbon_get_post_meta( get_the_ID(), 'descr' );
			$summa       = carbon_get_post_meta( get_the_ID(), 'summa' );
			if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
				$ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
			} else {
				$ref = carbon_get_post_meta( $post_id, 'ref' );
			}
			?>
            <div class="bonus">
                <div class="name color5" <?php if ( $color_cashback ): echo "style='background-color:" . $color_cashback . ";'"; endif; ?>>
					<?php echo __( 'CASHBACK', 'jgambling' ); ?>
                    <span><?php echo $summa; ?></span>
                </div>
                <div class="content">
					<?php echo $casino_desc; ?>
                    <a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
                       target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
                </div>
            </div>
		<? endwhile;
	endif;
endif;