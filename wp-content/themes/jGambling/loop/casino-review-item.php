<?
$plus   = carbon_get_comment_meta( $comment->comment_ID, 'plus' );
$minus  = carbon_get_comment_meta( $comment->comment_ID, 'minus' );
$rating = carbon_get_comment_meta( $comment->comment_ID, 'rating' );
?>
<div class="item ">
	<div class="avatar">
		<img src="<?php echo get_template_directory_uri() ?>/assets/img/svg/user.svg">
		<div><?php echo $comment->comment_author ?></div>
	</div>
	<div class="content">
		<div class="date"><?php echo __( 'Published', 'jgambling' ); ?>: <?php echo date( 'd F', strtotime( $comment->comment_date ) ); ?></div>
		<?php echo draw_rating( $rating ) ?>
		<?php if ( $plus ): ?>
			<p>
				<img src="<?php echo get_template_directory_uri() ?>/assets/img/svg/plus.svg">
				<?php echo $plus; ?>
			</p>
		<?php endif; ?>

		<?php if ( $minus ): ?>
			<p>
				<img src="<?php echo get_template_directory_uri() ?>/assets/img/svg/minus.svg">
				<?php echo $minus; ?>
			</p>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>