<?php get_header(); ?>
<?php while ( have_posts() ):the_post(); ?>
    <div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
			dimox_breadcrumbs();
		} ?>
    </div>
    <div class="flex">
        <div class="page-content">
            <div class="articles-page content_area">
                <h1><?php echo get_the_title(); ?></h1>
				<?php the_content(); ?>
            </div>
            <div class="articles-page">
				<?php comments_template(); ?>
            </div>
        </div>
        <aside class="right-sidebar">
			<?
			$casino = carbon_get_post_meta( get_the_ID(), 'cas' )[0]['id'];
			if ( $casino ):
				if ( carbon_get_post_meta( get_the_ID(), 'ref_bonus' ) ) {
					$casino_ref = carbon_get_post_meta( get_the_ID(), 'ref_bonus' );
                } else {
					$casino_ref = carbon_get_post_meta( $casino, 'ref' );

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
				$logo_att  = carbon_get_post_meta( $casino, 'img_single' );
				$logo_src  = aq_resize( wp_get_attachment_url( $logo_att ), 282, 116, true, true, true );
				$type_term = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'all' ) );
				if ( $type_term ) {
					$type_term_first = $type_term[0]->name;
					$type_term_link  = get_term_link( $type_term[0]->term_id, 'type' );
				}
				?>
                <div class="bonus-info">
                    <img src="<?php echo $logo_src ?>">
                    <div class="content">
						<?php echo __( 'Casino bonus', 'jgambling' ); ?>:
                        <a href="<?php echo get_the_permalink( $casino ) ?>"><?php echo get_the_title( $casino ); ?></a><br>
						<?php if ( $type_term_link ): ?>
							<?php echo __( 'Bonus type', 'jgambling' ); ?>: <a
                                    href="<?php echo $type_term_link; ?>"><?php echo $type_term_first; ?></a><br>
						<?php endif; ?>

						<?php if ( $wager ): ?>
							<?php echo __( 'Wager', 'jgambling' ); ?>: <?php echo $wager; ?><br>
						<?php endif; ?>
						<?php if ( $bcode ): ?>
							<?php echo __( 'Bonus code', 'jgambling' ); ?>: <?php echo $bcode; ?><br>
						<?php endif; ?>
						<?php if ( $summa ): ?>
							<?php echo __( 'Bonus amount', 'jgambling' ); ?>: <?php echo $summa; ?><br>
						<?php endif; ?>
                        <a href="<?php echo $casino_ref; ?>" rel="nofollow" target="_blank" class="get_bonus">
							<?php echo __( 'Get bonus', 'jgambling' ); ?>
                        </a>
                    </div>
                </div>
			<?php endif; ?>
			<?php dynamic_sidebar( 'category_single' ); ?>
        </aside>
    </div>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>
