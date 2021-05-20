<?php get_header(); ?>
<div class="flex">
    <div class="page-content">
        <div class="articles-page">
            <div class="flex article-items">
                <div style="display: flex;flex-direction: column;align-items: center;width: 100%;font-size: 18px;">
                    <img style="width: 300px;" src="<?php echo get_template_directory_uri() ?>/assets/img/404.png" alt="">
                    <span><?php echo __( 'Unfortunately, the page you are on was not found. Try to go to', 'jgambling' ); ?>
                        <a href="<?php echo home_url( '/' ) ?>"><?php echo __( 'homepage', 'jgambling' ) ?></a> <?php echo __( 'and try again.', 'jgambling' ) ?></span>
                </div>
            </div>
        </div>
    </div>
    <aside class="right-sidebar">
		<?php dynamic_sidebar( 'category_single' ); ?>
    </aside>
</div>
</div>
<?php get_footer(); ?>
