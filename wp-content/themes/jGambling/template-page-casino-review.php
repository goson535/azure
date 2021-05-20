<?
/*
 *
 * Template name: Single casino review*/
?>
<?php get_header(); ?>
<?php while ( have_posts() ):the_post();
	$post_id     = get_the_ID();
	$rating      = carbon_get_post_meta( $post_id, 'rating' );
	$ref         = carbon_get_post_meta( $post_id, 'ref' );
	$ceil_rating = ceil( $rating );
	$logo_att    = carbon_get_post_meta( $post_id, 'img_single' );
	$logo_src    = aq_resize( wp_get_attachment_url( $logo_att ), 194, 108, true, true, true );
	if ( carbon_get_post_meta( $post_id, 'custom_h1' ) ) {
		$h1 = carbon_get_post_meta( $post_id, 'custom_h1' );
	} else {
		$h1 = get_the_title();
	}

	/*Bonuses*/
	$welcome         = carbon_get_post_meta( $post_id, 'welcome' );
	$welcome_desc    = carbon_get_post_meta( $post_id, 'welcome_desc' );
	$no_deposit      = carbon_get_post_meta( $post_id, 'no_deposit' );
	$no_deposit_desc = carbon_get_post_meta( $post_id, 'no_deposit_desc' );
	$reload          = carbon_get_post_meta( $post_id, 'reload' );
	$reload_desc     = carbon_get_post_meta( $post_id, 'reload_desc' );
	$freespins       = carbon_get_post_meta( $post_id, 'freespins' );
	$freespins_desc  = carbon_get_post_meta( $post_id, 'freespins_desc' );
	$cashback        = carbon_get_post_meta( $post_id, 'cashback' );
	$cashback_desc   = carbon_get_post_meta( $post_id, 'cashback_desc' );


	$color_welcome    = carbon_get_theme_option( 'color-welcome' );
	$color_no_deposit = carbon_get_theme_option( 'color-no-deposit' );
	$color_reload     = carbon_get_theme_option( 'color-reload' );
	$color_freespins  = carbon_get_theme_option( 'color-freespins' );
	$color_cashback   = carbon_get_theme_option( 'color-cashback' );

	$color_star = carbon_get_theme_option( 'color-stars' );
	if ( $color_star ) {
		echo "<style>";
		echo ".set_rating > label:before {
    position: relative;
     font-family: \"Font Awesome 5 Free\";
    font-weight: 700;
    display: block;
    content: \"\f005\" ;
    color: " . $color_star . "; 
    background: #d2d2d2;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.set_rating > label:hover:before,
.set_rating > label:hover ~ label:before,
.set_rating > label.selected:before,
.set_rating > label.selected ~ label:before {
    color: " . $color_star . ";
    background: " . $color_star . ";
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}";
		echo "</style>";
	}

	?>
	<div class="navi">
		<?php if ( function_exists( 'dimox_breadcrumbs' ) ) {
			dimox_breadcrumbs();
		} ?>
	</div>
	<?php
	/*
		$current_county_user = get_user_country();
		$term_list           = wp_get_post_terms( get_the_ID(), 'restricted', array( 'fields' => 'all' ) );
		$is_restricted       = 0;
		foreach ( $term_list as $item ) {
			if ( carbon_get_term_meta( $item->term_id, 'iso' ) == $current_county_user ) {
				$is_restricted = 1;
				$country       = $item->name;
				$flag_att      = carbon_get_term_meta( $item->term_id, 'country_image' );
				$flag_src      = wp_get_attachment_url( $flag_att );
				break;
			}
		}

	*/
	?>
	<div class="flex">
		<div class="casino-page">
			<div class="top-info">
				<div class="content">
					<div class="image">
						<img src="<?php echo $logo_src ?>">
					</div>
					<div class="info">
						<div class="flex">
							<div>
								<div class="rating" <?php if ( $color_star ): echo "style='color:" . $color_star . ";'"; endif; ?>>
									<span><?php echo number_format( $rating, 1 ); ?></span> / 5
									<div>
										<?php echo draw_rating( $ceil_rating ) ?>
									</div>
								</div>
								<div class="name">

									<h1><?php echo $h1; ?></h1>
								</div>
							</div>
							<a href="<?php echo $ref; ?>" rel="nofollow" target="_blank"
							   class="play"><?php echo __( 'Play', 'jgambling' ); ?>
								&nbsp;<?php echo get_the_title(); ?></a>
						</div>
						<div class="main-content content_area">
							<?php
							$s        = get_the_content();
							$text_exp = explode( ".", $s );
							$s_first  = $text_exp[0];
							unset( $text_exp[0] );
							$s_second = implode( ".", $text_exp );
							?>
							<p> <?php echo $s_first; ?>.</p>
							<div class="hidden">
								<?php echo apply_filters( 'the_content', $s_second ); ?>
							</div>
							<a class="hide_show"><?php echo __( 'Show all', 'jgambling' ); ?></a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="links">
					<a href="#b1"><?php echo __( 'Main info', 'jgambling' ); ?></a>
					<a href="#b2"><?php echo __( 'Casino reviews', 'jgambling' ); ?></a>
					<?
					if ( get_full_country() AND wp_count_comments() ) {
						?>
						<div style="display: inline-block;margin-left: 15px;font-weight: 500;">
							<?
							if ( has_term( get_full_country(), 'restricted' ) ) { ?>
								<img class="country_access"
								     src="<?php echo get_template_directory_uri() ?>/assets/img/svg/not_allow.svg"
								     alt="">
								<img class="country_mini" src="<?php echo get_full_country_flag() ?>" alt="">
								<span class="single_casino_access"><?php echo __( 'Forbidden to players from', 'jgambling' ) ?>
									&nbsp;<?php echo get_full_country(); ?> </span>
							<?php } else { ?>
								<img class="country_access"
								     src="<?php echo get_template_directory_uri() ?>/assets/img/svg/allow.svg"
								     alt="">
								<img class="country_mini" src="<?php echo get_full_country_flag() ?>" alt="">
								<span class="single_casino_access"><?php echo __( 'Accept players from', 'jgambling' ) ?>
									<?php echo get_full_country(); ?></span>
								<?php
							}
							?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="flex">
				<div class="left-col">
					<?php if ( $no_deposit ): ?>
						<div class="bonus">
							<div class="name color2" <?php if ( $color_no_deposit ): echo "style='background-color:" . $color_no_deposit . ";'"; endif; ?>>
								<?php echo __( 'NO DEPOSIT BONUS', 'jgambling' ); ?>
								<span><?php echo $no_deposit; ?></span>
							</div>
							<div class="content">
								<?php echo $no_deposit_desc; ?>
								<a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
								   target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $freespins ): ?>
						<div class="bonus">
							<div class="name color4" <?php if ( $color_freespins ): echo "style='background-color:" . $color_freespins . ";'"; endif; ?>>
								<?php echo __( 'FREESPINS', 'jgambling' ); ?>
								<span><?php echo $freespins; ?></span>
							</div>
							<div class="content">
								<?php echo $freespins_desc; ?>
								<a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
								   target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $welcome ): ?>
						<div class="bonus">
							<div class="name color1" <?php if ( $color_welcome ): echo "style='background-color:" . $color_welcome . ";'"; endif; ?>>
								<?php echo __( 'WELCOME BONUS', 'jgambling' ); ?>
								<span><?php echo $welcome; ?></span>
							</div>
							<div class="content">
								<?php echo $welcome_desc ?>
								<a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
								   target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $reload ): ?>
						<div class="bonus">
							<div class="name color3" <?php if ( $color_reload ): echo "style='background-color:" . $color_reload . ";'"; endif; ?>>
								<?php echo __( 'RELOAD BONUS', 'jgambling' ); ?>
								<span><?php echo $reload; ?></span>
							</div>
							<div class="content">
								<?php echo $reload_desc; ?>
								<a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
								   target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $cashback ): ?>
						<div class="bonus">
							<div class="name color5" <?php if ( $color_cashback ): echo "style='background-color:" . $color_cashback . ";'"; endif; ?>>
								<?php echo __( 'CASHBACK', 'jgambling' ); ?>
								<span><?php echo $cashback; ?></span>
							</div>
							<div class="content">
								<?php echo $cashback_desc; ?>
								<a href="<?php echo $ref; ?>" class="get custom_color" rel="nofollow"
								   target="_blank"><?php echo __( 'Get bonus', 'jgambling' ); ?></a>
							</div>
						</div>
					<?php endif; ?>




					<?php dynamic_sidebar( 'single-casino-left' ); ?>
				</div>
				<?
				/*Main fields*/
				$site        = carbon_get_post_meta( $post_id, 'site' );
				$founded     = carbon_get_post_meta( $post_id, 'founded' );
				$min_deposit = carbon_get_post_meta( $post_id, 'min_deposit' );
				$min_cashout = carbon_get_post_meta( $post_id, 'min_cashout' );
				$lang        = carbon_get_post_meta( $post_id, 'lang' );
				$email       = carbon_get_post_meta( $post_id, 'email' );
				$live_chat   = carbon_get_post_meta( $post_id, 'live_chat' );
				$support     = carbon_get_post_meta( $post_id, 'support' );

				?>
                <div class="right-col">
                    <div class="info-block" id="b1">
                        <div class="name"><?php echo __( 'Basic information', 'jgambling' ); ?></div>
                        <table>
							<?php if ( $site ): ?>
                                <tr>
                                    <td><?php echo __( 'Official site', 'jgambling' ); ?></td>
                                    <td><a rel="nofollow" target="_blank"
                                           href="<?php echo $ref; ?>"><?php echo $site; ?></a>
                                    </td>
                                </tr>
							<?php endif; ?>

							<?php if ( $founded ): ?>
                                <tr>
                                    <td><?php echo __( 'Founding date', 'jgambling' ); ?></td>
                                    <td><?php echo $founded; ?></td>
                                </tr>
							<?php endif; ?>
							<?php echo get_tax_items( $post_id, 'restricted', __( 'Restricted countries', 'jgambling' ) ); ?>
							<?php echo get_tax_items( $post_id, 'license', __( 'Licenses', 'jgambling' ) ); ?>
							<?php echo get_tax_items( $post_id, 'soft', __( 'Softs', 'jgambling' ) ); ?>
							<?php
							wp_reset_query();
							$c_fields_basic = carbon_get_post_meta( get_the_ID(), 'c_fields_basic' );
							if ( $c_fields_basic ): ?>
								<?php foreach ( $c_fields_basic as $el ) : ?>
                                    <tr>
										<?php
										$title = $el['basic_title'];
										$desc  = $el['basic_description']; ?>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $desc; ?></td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>

                        </table>
                    </div>
                    <div class="info-block">
                        <div class="name"><?php echo __( 'Payment info', 'jgambling' ); ?></div>
                        <table>
							<?php echo get_tax_items( $post_id, 'deposit', __( 'Deposit methods', 'jgambling' ) ); ?>
							<?php echo get_tax_items( $post_id, 'currency', __( 'Currency', 'jgambling' ) ); ?>
							<?php echo get_tax_items( $post_id, 'cashout', __( 'Withdrawal methods', 'jgambling' ) ); ?>
							<?php if ( $min_deposit ): ?>
                                <tr>
                                    <td><?php echo __( 'Minimum deposit amount', 'jgambling' ); ?></td>
                                    <td><?php echo $min_deposit; ?></td>
                                </tr>
							<?php endif; ?>
							<?php if ( $min_cashout ): ?>
                                <tr>
                                    <td><?php echo __( 'Minimum withdrawal amount', 'jgambling' ); ?></td>
                                    <td><?php echo $min_cashout; ?></td>
                                </tr>
							<?php endif; ?>
							<?php
							wp_reset_query();
							$c_fields_payment = carbon_get_post_meta( get_the_ID(), 'c_fields_payment' );
							if ( $c_fields_payment ): ?>
								<?php foreach ( $c_fields_payment as $el ) : ?>
                                    <tr>
										<?php
										$title = $el['payment_title'];
										$desc  = $el['payment_description']; ?>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $desc; ?></td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
                        </table>
                    </div>
                    <div class="info-block">
                        <div class="name"><?php echo __( 'Support', 'jgambling' ); ?></div>
                        <table>
							<?php if ( $lang ): ?>
                                <tr>
                                    <td><?php echo __( 'Language', 'jgambling' ); ?></td>
                                    <td><?php echo $lang; ?></td>
                                </tr>
							<?php endif; ?>
							<?php if ( $email ): ?>
                                <tr>
                                    <td><?php echo __( 'Email', 'jgambling' ); ?></td>
                                    <td><?php echo $email; ?></td>
                                </tr>
							<?php endif; ?>
							<?php if ( $live_chat ): ?>
                                <tr>
                                    <td><?php echo __( 'Live-chat', 'jgambling' ); ?></td>
                                    <td><?php echo $live_chat; ?></td>
                                </tr>
							<?php endif; ?>
							<?php if ( $support ): ?>
                                <tr>
                                    <td><?php echo __( 'Support', 'jgambling' ); ?></td>
                                    <td><?php echo $support ?></td>
                                </tr>
							<?php endif; ?>

							<?php
							wp_reset_query();
							$c_fields_support = carbon_get_post_meta( get_the_ID(), 'c_fields_support' );
							if ( $c_fields_support ): ?>
								<?php foreach ( $c_fields_support as $el ) : ?>
                                    <tr>
										<?php
										$title = $el['support_title'];
										$desc  = $el['support_description']; ?>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $desc; ?></td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
                        </table>
                    </div>
					<?php
					wp_reset_query();
					get_template_part( 'parts/casino-reviews' ); ?>
                </div>
			</div>
		</div>
		<aside class="right-sidebar">
			<?php
			wp_reset_query();
			$plus = carbon_get_post_meta( get_the_ID(), 'tab1' );
			if ( $plus ): ?>
				<div class="casino-advantages">
					<div class="name"><?php echo __( 'Casino advantages', 'jgambling' ); ?></div>
					<ul>
						<?php foreach ( $plus as $item ) :
							$p = $item['plus']; ?>
							<li><?php echo $p; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php
			wp_reset_query();
			$plus = carbon_get_post_meta( get_the_ID(), 'tab2' );
			if ( $plus ): ?>
                <div class="casino-advantages dislike">
                    <div class="name"><?php echo __( 'Casino cons', 'jgambling' ); ?></div>
                    <ul>
						<?php foreach ( $plus as $item ) :
							$p = $item['plus']; ?>
                            <li><?php echo $p; ?></li>
						<?php endforeach; ?>
                    </ul>
                </div>
			<?php endif; ?>

			<?
			$baza = strip_tags( wp_nav_menu( array(
				'theme_location' => 'baza',
				'echo'           => false
			) ), "<a>" );
			if ( $baza ):
				?>
				<div class="info-base">
					<div class="name"><?php echo __( 'Knowledge base', 'jgambling' ); ?></div>
					<?php echo $baza; ?>
				</div>
			<?php endif; ?>
			<?
			if ( carbon_get_post_meta( get_the_ID(), 'about_register' ) ):
				?>
				<div class="reg-block">
					<a href="<?php echo carbon_get_post_meta( get_the_ID(), 'about_register' ); ?>">
						<?php echo __( 'All about register', 'jgambling' ); ?> <?php echo __( 'in', 'jgambling' ); ?>
						<br/> <?php echo get_the_title(); ?>
					</a>
				</div>
			<?php endif; ?>
			<?php dynamic_sidebar( 'single-casino-right' ); ?>
		</aside>
	</div>
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>

