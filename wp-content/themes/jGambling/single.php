<?php get_header(); ?>
<?php while ( have_posts() ):the_post();
	$first_category = get_the_category()[0];
	?>
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

				<?php if ( ! carbon_get_theme_option( 'hide_comments' ) ):
					comments_template();
				endif;
				?>
            </div>
        </div>
        <aside class="right-sidebar">
			<?php dynamic_sidebar( 'category_single' ); ?>
        </aside>
    </div>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>
