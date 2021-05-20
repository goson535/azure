<?php get_header(); ?>
	<div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) dimox_breadcrumbs(); ?>
	</div>
	<div class="flex">
		<div class="page-content">
			<div class="articles-page">
				<?
				$term    = get_queried_object();
				$term_id = $term->term_id;
				if ( carbon_get_term_meta( $term_id, 'h1' ) ) {
					$h1 = carbon_get_term_meta( $term_id, 'h1' );
				} else {
					$h1 = single_term_title( '', false );
				}
				$textbefore = carbon_get_term_meta( $term_id, 'before' );
				?>
				<h1><?php echo $h1; ?></h1>
				<?php if ( $textbefore ): ?>
					<div class="content_area">
						<?php echo apply_filters( 'the_content', $textbefore ); ?>
					</div>
				<?php endif; ?>
				<div class="bonus-list">
					<div class="flex2">

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
				<?
				$description = term_description();
				if ( $description ): ?>
					<div class="content_area">
						<?php echo apply_filters( 'the_content', $description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<aside class="right-sidebar">
			<?php dynamic_sidebar( 'slots' ) ?>
		</aside>
	</div>
	</div>
<?php get_footer(); ?>