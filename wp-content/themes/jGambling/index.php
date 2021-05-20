<?php get_header(); ?>
<div class="navi">
    <?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
		dimox_breadcrumbs();
	} ?>
</div>
<div class="flex">
    <div class="page-content">
        <div class="articles-page ">
            <h1><?php echo single_cat_title( '' ); ?></h1>
			<?
			global $wp_query;
			$category = get_category( get_query_var( 'cat' ) );
			$cat_id   = $category->cat_ID;
			$before   = carbon_get_term_meta( $cat_id, 'before' );
			$after    = carbon_get_term_meta( $cat_id, 'after' );

			wp_reset_query();
			?>
            <div class="flex article-items">
				<?php while ( have_posts() ):the_post(); ?>
					<?php get_template_part( 'loop/post-simple-item' ); ?>
				<?php endwhile; ?>
            </div>
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
                <script>
                    var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                    var posts = '<?php echo serialize( $wp_query->query_vars ); ?>';
                    var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                    var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                </script>
                <button class="load_more_category"><?php echo __( 'Load more', 'jgambling' ); ?></button>
			<?php endif; ?>



        </div>
    </div>
    <aside class="right-sidebar">
		<?php dynamic_sidebar( 'category_single' ); ?>
    </aside>
</div>
</div>
<?php get_footer(); ?>
