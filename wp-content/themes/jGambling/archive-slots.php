<?php get_header(); ?>
    <div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
			dimox_breadcrumbs();
		} ?>
    </div>
    <div class="flex">
        <div class="page-content">
			<?
			if ( carbon_get_theme_option( 'slot_h1' ) ) {
				$h1 = carbon_get_theme_option( 'slot_h1' );
			} else {
				$h1 = __( "Slots", "jgambling" );
			}
			?>
            <div class="articles-page">
                <h1><?php echo $h1; ?></h1>
				<?php if ( carbon_get_theme_option( 'before_list' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'before_list' ) ); ?>
                    </div>
				<?php endif; ?>
                <div class="slots small ajax_block">
                    <div class="flex2">
						<?
						global $wp_query;
						$per_page_global = carbon_get_theme_option( 'slot_count' );
						if ( $per_page_global ) {
							$perpage = $per_page_global;
						} else {
							$perpage = 15;
						}
						$args = array_merge( $wp_query->query_vars, [ 'posts_per_page' => $perpage ] );
						query_posts( $args );
						if ( have_posts() ):
							while ( have_posts() ): the_post();
								get_template_part( 'loop/slot-item' );
							endwhile;
						else: ?>
							<?php echo __( "Slots not found!", "jgambling" ) ?>
						<?php endif; ?>
                    </div>
					<?php if ( $wp_query->max_num_pages > 1 ) : ?>
                        <script>
                            var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                            var posts = '<?php echo serialize( $wp_query->query_vars ); ?>';
                            var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                            var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                        </script>
                        <button class="loadmore slotoload"><?php echo __( "Load more", "jgambling" ); ?></button>
					<?php endif; ?>
                </div>
				<?php if ( carbon_get_theme_option( 'after_list' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'after_list' ) ); ?>
                    </div>
				<?php endif; ?>
                <div class="share">
                    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter"></div>
                </div>
            </div>
        </div>
		<?
		$terms = get_terms( array(
			'taxonomy'   => array( 'software' ),
			'hide_empty' => true,
		) );
		?>
        <aside class="right-sidebar">
            <div class="slot-search">
                <div class="field">
                    <input type="text" class="sort_slots_input" placeholder="<?php echo __( "Find by slot name...", "jgambling" ); ?>">
                    <button></button>
                </div>
				<?php if ( $terms ): ?>
                    <div class="sort1">
                        <p><?php echo __( "Game Providers", "jgambling" ); ?></p>
						<?
						$count = 1;
						foreach ( $terms as $term ) {
							echo '<input type="checkbox" class="checkbox sort_slots" name="software[]" id="software' . $count . '" value="' . $term->slug . '">
							<label for="software' . $count . '">
							' . $term->name . ' (' . $term->count . ')
							</label>';
							$count ++;
						}
						?>
                    </div>
				<?php endif; ?>
                <div class="sort2">
                    <input type="checkbox" class="checkbox sort_slots bonus_s" id="ch11" checked><label for="ch11"><?php echo __( "Bonus game", "jgambling" ); ?></label>
                    <input type="checkbox" class="checkbox sort_slots free_spin_s" id="ch12" checked><label for="ch12"><?php echo __( "Free Spins", "jgambling" ); ?></label>
                    <input type="checkbox" class="checkbox sort_slots scatter_s" id="ch13" checked><label for="ch13"><?php echo __( "Scatter symbol", "jgambling" ); ?></label>
                    <input type="checkbox" class="checkbox sort_slots wild_s" id="ch14" checked><label for="ch14"><?php echo __( "Wild symbol", "jgambling" ); ?></label>
                    <input type="checkbox" class="checkbox sort_slots fast_speed_s" id="ch15" checked><label for="ch15"><?php echo __( "Fast spin", "jgambling" ); ?></label>
                </div>
            </div>
			<?php dynamic_sidebar( 'slots' ) ?>
        </aside>
    </div>
    </div>
<?php get_footer(); ?>