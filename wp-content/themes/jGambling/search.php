<?php get_header(); ?>
<div class="navi">
	<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
		dimox_breadcrumbs();
	} ?>
</div>
<div class="flex">
    <div class="page-content">
        <div class="index-rating content_area ">
            <h1><?php echo __( 'Search result for:', 'jgambling' ); ?><?php echo get_search_query(); ?></h1>
			<?php
			$exist = false;
			/*POSTS Search result*/
			$args = [ 's' => get_search_query(), 'post_type' => 'casino' ];
			$q    = new WP_Query( $args );
			if ( $q->have_posts() ):
				echo "<h2>" . __( 'Casinos', 'jgambling' ) . "</h2>";
				echo '<div class="flex2 grid_rating">';

				while ( $q->have_posts() ): $q->the_post();
					get_template_part( 'loop/casino-grid-item' );
					$exist = true;
				endwhile;
				echo "</div>";
			endif;
			/*CASINO Search result*/
			wp_reset_query();
			$args = [ 's' => get_search_query(), 'post_type' => 'post' ];
			$q    = new WP_Query( $args );
			if ( $q->have_posts() ):
				echo "<div class=\"articles-page \">";
				echo "<h2>" . __( 'Articles', 'jgambling' ) . "</h2>";
				echo "<div class=\"flex article-items\">";
				while ( $q->have_posts() ): $q->the_post();
					get_template_part( 'loop/post-simple-item' );
					$exist = true;
				endwhile;
				echo "</div>";
				echo "</div>";
			endif;
			/*SLOTS Search result*/
			wp_reset_query();
			$args = [ 's' => get_search_query(), 'post_type' => 'slots' ];
			$q    = new WP_Query( $args );
			if ( $q->have_posts() ):
				echo "<div class=\"articles-page \">";
				echo "<h2>" . __( 'Slots', 'jgambling' ) . "</h2>";
				echo "<div class=\"slots small ajax_block\">";
				echo "<div class=\"flex2\">";
				while ( $q->have_posts() ): $q->the_post();
					get_template_part( 'loop/slot-item' );
					$exist = true;
				endwhile;
				echo "</div>";
				echo "</div>";
				echo "</div>";
			endif;

			/*BONUS Search result*/
			wp_reset_query();
			$args = [ 's' => get_search_query(), 'post_type' => 'bonus' ];
			$q    = new WP_Query( $args );
			if ( $q->have_posts() ):
				echo "<div class=\"articles-page \">";
				echo "<h2>" . __( 'Bonuses', 'jgambling' ) . "</h2>";
				echo "<div class=\"ajax_block_bonus\">";
				echo "<div class=\"bonus-list flex2\">";
				while ( $q->have_posts() ): $q->the_post();
					get_template_part( 'loop/bonus-item' );
					$exist = true;
				endwhile;
				echo "</div>";
				echo "</div>";
				echo "</div>";
			endif;
			if ( ! $exist ) {
				echo __( 'Unfortunately, your search returned no results! Try another keyword.', 'jgambling' );
			} ?>
        </div>
    </div>
    <aside class="right-sidebar">
		<?php dynamic_sidebar( 'category_single' ); ?>
    </aside>
</div>
</div>
<?php get_footer(); ?>
