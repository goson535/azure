<?php get_header(); ?>
    <div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
			dimox_breadcrumbs();
		} ?>
    </div>
    <div class="flex">
        <div class="page-content">
			<?
			if ( carbon_get_theme_option( 'bonus_h1' ) ) {
				$h1 = carbon_get_theme_option( 'bonus_h1' );
			} else {
				$h1 = __( "Bonuses", "jgambling" );
			}
			?>
            <div class="articles-page">
                <h1><?php echo $h1; ?></h1>
				<?php if ( carbon_get_theme_option( 'before_bonus' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'before_bonus' ) ); ?>
                    </div>
				<?php endif; ?>
                <div class="ajax_block_bonus">
                    <div class="bonus-list flex2">
						<?
						global $wp_query;
						$per_page_global = carbon_get_theme_option( 'bonus_count' );
						if ( $per_page_global ) {
							$perpage = $per_page_global;
						} else {
							$perpage = 15;
						}
						$args = array_merge( $wp_query->query_vars, [ 'posts_per_page' => $perpage ] );
						query_posts( $args );
						if ( have_posts() ):
							while ( have_posts() ): the_post();
								get_template_part( 'loop/bonus-item' );
							endwhile;
						else: ?>
							<?php echo __( "No bonus found", "jgambling" ); ?>
						<?php endif; ?>
                    </div>
					<?php if ( $wp_query->max_num_pages > 1 ) : ?>
                        <script>
                            var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                            var posts = '<?php echo serialize( $wp_query->query_vars ); ?>';
                            var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                            var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                        </script>
                        <button class="loadmore bonusload"><?php echo __( "Load more", "jgambling" ); ?></button>
					<?php endif; ?>
                </div>
				<?php if ( carbon_get_theme_option( 'after_bonus' ) ): ?>
                    <div class="content_area">
						<?php echo apply_filters( 'the_content', carbon_get_theme_option( 'after_bonus' ) ); ?>
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
			'taxonomy'   => array( 'type' ),
			'hide_empty' => true,
		) );
		?>
        <aside class="right-sidebar">
            <div class="slot-search">
                <div class="field">
                    <input type="text" class="sort_bonus_input"
                           placeholder="<?php echo __( "Find by bonus name", "jgambling" ); ?>">
                    <button></button>
                </div>
                <div class="sort2">
					<?php foreach ( $terms as $item ): ?>
                        <input type="checkbox" class="checkbox" id="<?php echo $item->slug; ?>"
                               value="<?php echo $item->slug; ?>" checked>
                        <label for="<?php echo $item->slug; ?>"><?php echo $item->name; ?></label>
					<?php endforeach; ?>
                </div>
            </div>
			<?php dynamic_sidebar( 'bonuses' ) ?>
        </aside>
    </div>
    </div>
<?php get_footer(); ?>