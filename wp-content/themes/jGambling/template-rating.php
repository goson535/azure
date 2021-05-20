<?
/*
  * Template name: Rating casino template
  * */
get_header(); ?>
<?php while ( have_posts() ):the_post(); ?>
    <div class="navi">
	    <?php if ( function_exists( 'dimox_breadcrumbs' ) ) dimox_breadcrumbs(); ?>
    </div>
    <div class="flex">
        <div class="page-content">
            <div class="index-rating content_area">
                <div class="content_header"> <h1><?php echo get_the_title(); ?></h1><sup><?php echo __( "Total", "jgambling" ); ?> <?php echo wp_count_posts( 'casino' )->publish ?></sup></div>
				<?php the_content(); ?>
            </div>
        </div>
        <aside class="right-sidebar">
			<?php dynamic_sidebar( 'rating' ); ?>
        </aside>
    </div>
<?php endwhile; ?>
    </div>
<?php get_footer() ?>