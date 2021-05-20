<?php get_header(); ?>
    <div class="navi">
		<?php
		if ( function_exists( 'dimox_breadcrumbs' ) ) {
			dimox_breadcrumbs();
		}
		wp_reset_query();
		?>
    </div>
    <div class="flex">
        <div class="page-content">
            <div class="index-rating content_area">
				<?
				if ( carbon_get_theme_option( 'h1_casino' ) ) {
					$h1 = carbon_get_theme_option( 'h1_casino' );
				} else {
					$h1 = __( "Casinos", "jgambling" );
				}
				?>
                <div class="content_header"><h1><?php echo $h1; ?></h1>
                    <sup><?php echo __( "Total: ", "jgambling" ) ?><?php echo wp_count_posts( 'casino' )->publish ?></sup>
                </div>
				<?php if ( carbon_get_theme_option( 'before_list_casino' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'before_list_casino' ) ); ?>
                    </div>
				<?php endif; ?>

				<?php echo do_shortcode( '[table num=999]' ); ?>
				<?php if ( carbon_get_theme_option( 'after_list_casino' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'after_list_casino' ) ); ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
        <aside class="right-sidebar">
			<?php dynamic_sidebar( 'rating' ); ?>
        </aside>
    </div>
    </div>
<?php get_footer() ?>