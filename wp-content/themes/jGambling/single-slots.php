<?php get_header(); ?>
<?php while ( have_posts() ):the_post(); ?>
	<?
	$current_slot    = get_the_ID();
	$back_url_post   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	$back_url_option = wp_get_attachment_url( carbon_get_theme_option( 'nobackslot' ) );
	if ( $back_url_post ) {
		$back = $back_url_post;
	} else {
		$back = $back_url_option;
	}


	$image_att = carbon_get_post_meta( get_the_ID(), 'slot_img_grid' );
	if ( $image_att ) {
		$image_src = aq_resize( wp_get_attachment_image_url( $image_att, 'full' ), 165, 245, true, true, true );
	}


	$soft_term       = wp_get_post_terms( get_the_ID(), 'software', array( 'fields' => 'all' ) );
	$first_soft      = $soft_term[0]->name;
	$first_soft_slug = $soft_term[0]->slug;
	$first_soft_link = get_term_link( $soft_term[0]->term_id, 'software' );
	$frame           = carbon_get_post_meta( get_the_ID(), 'demo' );
	?>


    <style>
        .headers{
            height: 157px;
        }
    </style>
	<?php if ( $back ): ?>
        <div class="slot-game">
            <div class="bg"></div>
            <img src="<?php echo $back; ?>">
            <div class="iframe">
				<?php echo $frame; ?>
            </div>
            <div class="links">
                <noindex><a href="<?php echo carbon_get_post_meta( get_the_ID(), 'play_for_real' ) ?>" rel="nofollow"
                            target="_blank" class="a1"><?php echo __( 'Play for real', 'jgambling' ); ?></a></noindex>
                <a class="a2"><?php echo __( 'Play for free', 'jgambling' ); ?> <i
                            class="fa fa-caret-right"></i></a>
            </div>
        </div>
	<?php endif; ?>
    <div class="flex">
        <div class="page-content">
            <div class="articles-page">
                <h1><?php echo get_the_title(); ?></h1>
                <div class="content_area">
					<?php the_content(); ?>
                </div>
                <div class="share">
                    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter"></div>
                </div>
				<?
				$args = array(
					'post_type'      => 'slots',
					'posts_per_page' => 5,
					'post__not_in'   => array( $current_slot )
				);
				if ( $first_soft_slug ) {
					$args['software'] = $first_soft_slug;
				}

				$query = new WP_Query( $args );
				if ( $query->have_posts() ): ?>
                    <h2><?php echo __( 'Similar slots', 'jgambling' ); ?></h2>
                    <div class="slots small flex2">
						<?php while ( $query->have_posts() ): $query->the_post();
							get_template_part( 'loop/slot-item' );
						endwhile; ?>
                    </div>
				<?php endif; ?>

				<?php comments_template(); ?>
            </div>
        </div>
        <aside class="right-sidebar" style="will-change: min-height;">
            <div id="sidebar"
                 style=" transform: translate(0, 0); transform: translate3d(0, 0, 0); will-change: position, transform;">
                <div class="right-banner">
                    <a href="#"><img src="<?php echo aq_resize( $image_src, 276, 414, true, true, true ); ?>"
                                     class="slot_rounded"></a>
                </div>
                <div class="slot-params">
                    <div class="name"><?php echo __( 'Slot option', 'jgambling' ); ?></div>
					<?php if ( $first_soft ): ?>
                        <p><?php echo __( 'Software:', 'jgambling' ); ?> <a
                                    href="<?php echo $first_soft_link; ?>"><?php echo $first_soft; ?></a>
                        </p>
					<?php endif; ?>
                    <p><?php echo __( 'Bonus game:', 'jgambling' ); ?>
						<?php if ( carbon_get_post_meta( get_the_ID(), 'bonus_game' ) == 'yes' ) {
							echo '<i class="fa fa-check-circle"></i>';
						} else {
							echo '<i class="fa fa-times-circle"></i></p>';
						} ?>
                    </p>
                    <p><?php echo __( 'Free Spins', 'jgambling' ); ?>
						<?php if ( carbon_get_post_meta( get_the_ID(), 'free_spins' ) == 'yes' ) {
							echo '<i class="fa fa-check-circle"></i>';
						} else {
							echo '<i class="fa fa-times-circle"></i></p>';
						} ?>
                    </p>
                    <p><?php echo __( 'Scatter symbol:', 'jgambling' ); ?><?php if ( carbon_get_post_meta( get_the_ID(), 'scatter_symbol' ) == 'yes' ) {
							echo '<i class="fa fa-check-circle"></i>';
						} else {
							echo '<i class="fa fa-times-circle"></i></p>';
						} ?>
                    </p>
                    <p><?php echo __( 'Wild symbol', 'jgambling' ); ?>
						<?php if ( carbon_get_post_meta( get_the_ID(), 'wild_symbol' ) == 'yes' ) {
							echo '<i class="fa fa-check-circle"></i>';
						} else {
							echo '<i class="fa fa-times-circle"></i></p>';
						} ?>
                    </p>
                    <p><?php echo __( 'Fast spin', 'jgambling' ); ?>
						<?php if ( carbon_get_post_meta( get_the_ID(), 'fast_spin' ) == 'yes' ) {
							echo '<i class="fa fa-check-circle"></i>';
						} else {
							echo '<i class="fa fa-times-circle"></i></p>';
						} ?>
                    </p>
                </div>
            </div>
        </aside>
    </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
