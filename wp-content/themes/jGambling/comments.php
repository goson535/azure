<?php
wp_reset_query();
$post_id = get_the_ID();
$comment_id = '';
if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
	$text = $_POST['text'];
	$imya = $_POST['imya'];
	$mail = $_POST['mail'];
	$site = $_POST['site'];

	$data = array(
		'comment_post_ID'      => $post_id,
		'comment_author'       => $imya,
		'comment_author_email' => $mail,
		'comment_author_url'   => $site,
		'comment_content'      => $text,
		'comment_type'         => '',
		'comment_approved'     => 0,
		'comment_parent'       => 0,
		'user_id'              => 1,
		'comment_author_IP'    => '127.0.0.1',
		'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
	);

	$comment_id = wp_insert_comment( wp_slash( $data ) );
}
?>
<div class="comments">
    <div class="comments_name"><?php echo __( "Discussion", "jgambling" ); ?>
        (<?php echo wp_count_comments( $post_id )->approved; ?>)
    </div>
	<?php
	if ( wp_count_comments( $post_id )->approved ) {
		$comments    = get_comments( 'post_id=' . $post_id );
		foreach ( $comments as $comment ):
			$author = $comment->comment_author;
			$date    = date( 'd.m.Y', strtotime( $comment->comment_date ) );
			$content = $comment->comment_content;
			?>
            <div class="comment">
                <img src="<?php echo get_template_directory_uri() ?>/assets/img/avatar.jpg">
                <div class="text">
                    <div class="name">
                        <span><?php echo $author; ?></span> <?php echo __( "Published", "jgambling" ); ?>: <?php echo $date; ?>
                    </div>
					<?php echo $content; ?>
                </div>
                <div class="clear"></div>
            </div>
		<?php endforeach;
	} else {
		echo "<div style='margin-bottom: 10px'>" . __( 'No comments', 'jgambling' ) . "</div>";
	} ?>
    <div class="comments_name"><?php echo __( "Leave a comment", "jgambling" ); ?></div>
    <form class="add_comment" id="new_comment" action="" method="post">
        <textarea placeholder="<?php echo __('Comment*','jgambling')?>" name="text"></textarea>
        <div class="flex">
            <input type="text" name="imya" placeholder="<?php echo __( "Name", "jgambling" ); ?>*">
            <input type="text" name="mail" placeholder="<?php echo __( "Email", "jgambling" ); ?>*">
            <input type="text" name="site" placeholder="<?php echo __( "Website", "jgambling" ); ?>">
            <button><?php echo __( "Send", "jgambling" ); ?></button>
        </div>
		<?php if ( $comment_id ): ?>
            <span style="color: #005222;font-size: 15px;border: 1px solid;padding: 10px;margin-top: 15px;display: block;">
	            <?php echo __( "Your comment has been added. After moderation it will be published on the website.", "jgambling" ); ?>
</span>
		<?php endif; ?>
    </form>
</div>