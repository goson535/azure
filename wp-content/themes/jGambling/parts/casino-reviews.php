<?
$post_id  = get_the_ID();
$per_page = carbon_get_theme_option( 'comment_count' );
if ( ! $per_page ) {
	$per_page = 3;
}
$total    = wp_count_comments( $post_id )->approved;
$pages    = ceil( $total / $per_page );
$comments = get_comments( array(
	'post_id' => $post_id,
	'number'  => $per_page,
	'status'  => 'approve'
) );
?>
<div id="b2"></div>
<?php if ( $comments ): ?>
    <div class="reviews">
        <div class="name"><?php echo __( 'Casino reviews for ', 'jgambling' ); ?> <?php echo get_the_title( $post_id ); ?>
            (<?php echo wp_count_comments( $post_id )->approved; ?>)
        </div>
        <div class="ajax_items">
			<?
			foreach ( $comments as $comment ) :
				$plus = carbon_get_comment_meta( $comment->comment_ID, 'plus' );
				$minus = carbon_get_comment_meta( $comment->comment_ID, 'minus' );
				$rating = carbon_get_comment_meta( $comment->comment_ID, 'rating' );
				?>
                <div class="item ">
                    <div class="avatar">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/svg/user.svg">
                        <div><?php echo $comment->comment_author ?></div>
                    </div>
                    <div class="content">
                        <div class="date">
							<?php echo __( 'Published', 'jgambling' ); ?>
                            : <?php echo date( 'd F', strtotime( $comment->comment_date ) ); ?></div>
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
			<?php endforeach; ?>
        </div>
		<?php if ( $pages >= 2 ): ?>
            <script type="application/javascript">
                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                var current_page = 1;
                var max_pages = <?php echo $pages;  ?>;
            </script>
            <button class="load_more_commments"><?php echo __( 'Load more', 'jgambling' ); ?></button>
		<?php endif; ?>
    </div>
<?php endif; ?>
<form class="reviews-form">
    <script type="application/javascript">
        var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
        var post_id = <?php echo $post_id;  ?>;
    </script>
    <img src="<?php echo get_template_directory_uri() ?>/assets/img/svg/user.svg" class="avatar">
    <div class="content">
        <p><?php echo __( 'Rate the casino and write a review', 'jgambling' ); ?></p>
        <div class="set_rating">
            <label data-note="5">
                <input type="radio" name="rating" value="5" title="5 stars"> 5
            </label>
            <label data-note="4">
                <input type="radio" name="rating" value="4" title="4 stars"> 4
            </label>
            <label data-note="3">
                <input type="radio" name="rating" value="3" title="3 stars"> 3
            </label>
            <label data-note="2">
                <input type="radio" name="rating" value="2" title="2 stars"> 2
            </label>
            <label data-note="1">
                <input type="radio" name="rating" value="1" title="1 star"> 1
            </label>
        </div>
        <input type="text" placeholder="<?php echo __( 'Your name', 'jgambling' ); ?>" class="review-name">
        <input type="text" placeholder="<?php echo __( 'Your email', 'jgambling' ); ?>" class="review-email">
        <textarea placeholder="<?php echo __( 'Casino advantages', 'jgambling' ); ?>" class="plus"></textarea>
        <textarea placeholder="<?php echo __( 'Casino cons', 'jgambling' ); ?>" class="minus"></textarea>
        <div class="check">
            <input type="checkbox" id="ch2">
            <label for="ch2"><?php echo __( 'By clicking the "Send review" button, you consent to the processing', 'jgambling' ); ?>
                <a
                        href="/privacy-policy/"><?php echo __( 'personal data', 'jgambling' ); ?></a></label>
        </div>
        <button><?php echo __( 'Send review', 'jgambling' ); ?></button>
    </div>
    <div class="clear"></div>
</form>