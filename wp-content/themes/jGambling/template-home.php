<?
/*
  * Template name: Homepage
  * */
get_header();
?>
    <div class="flex">
        <div class="page-content">
            <div class="index-rating content_area">
				<?php while ( have_posts() ):the_post(); ?>
                    <div class="content_header"><h1><?php echo get_the_title(); ?></h1></div>
					<?php the_content() ?>
				<?php endwhile; ?>
            </div>
        </div>
        <aside class="right-sidebar">

			<?php dynamic_sidebar( 'home-right' ); ?>
        </aside>
    </div>
    </div>
<?php get_footer() ?>