<?php get_header(); ?>
<?php
$term    = get_queried_object();
$term_id = $term->term_id;
if ( carbon_get_term_meta( $term_id, 'h1' ) ) {
	$h1 = carbon_get_term_meta( $term_id, 'h1' );
} else {
	$h1 = single_term_title( '', false );
}
$textbefore = carbon_get_term_meta( $term_id, 'before' );
?>
	<div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) dimox_breadcrumbs(); ?>
	</div>
	<div class="flex">
		<div class="page-content">
			<div class="index-rating content_area">
				<div class="content_header"><h1><?php echo $h1; ?></h1></div>
				<?php
				if ( $textbefore ):
					echo apply_filters( 'the_content', $textbefore );
				endif;
				echo do_shortcode( '[table license="' . $term->slug . '"]' );
				$description = term_description();
				if ( $description ):
					echo apply_filters( 'the_content', $description );
				endif;
				?>
			</div>
		</div>
		<aside class="right-sidebar">
			<?php dynamic_sidebar( 'rating' ); ?>
		</aside>
	</div>
	</div>
<?php get_footer() ?>