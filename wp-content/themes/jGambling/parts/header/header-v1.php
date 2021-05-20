<div class="menubg"></div>
<nav class="mobile-menu">
	<?php

	if ( get_key() ):
		$ret = strip_tags( wp_nav_menu( array(
			'theme_location' => 'top',
			'echo'           => false
		) ), "<a><ul><li>" );
		if ( $ret ):
			echo $ret;
		else:
			echo "<ul><li><a href='/wp-admin/nav-menus.php'>" . __( 'Create menu to show it here', 'jgambling' ) . "</a></li></ul>";
		endif;
	else:
		echo notice();
	endif;
	$color_menu = carbon_get_theme_option( 'menucolor' );

	?>
</nav>
<div class="wrap">
	<header class="header" <?php if ( $color_menu ): echo "style='background:" . $color_menu . ";'"; endif; ?>>
		<div class="wrap">
			<div class="flex">
				<?php
				if ( carbon_get_theme_option( 'logo' ) ):
					$logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
				else:
					$logo = get_template_directory_uri() . '/assets/img/logo.png';
				endif;
				?>
				<div class="logo">
					<a href="<?php echo home_url( '/' ) ?>">
						<img src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name ' ) ?>"></a>
				</div>
				<?php if ( ! carbon_get_theme_option( 'hide_search' ) ): ?>
					<form action="/">
						<input type="text" name="s" placeholder="<?php echo __( 'Site search...', 'jgambling' ); ?>">
						<button></button>
					</form>
				<?php endif; ?>
				<div class="main_menu" id="main-nav">
					<?php
					if ( get_key() ):
						$ret = strip_tags( wp_nav_menu( array(
							'theme_location' => 'top',
							'echo'           => false
						) ), "<a><ul><li>" );
						if ( $ret ):
							echo $ret;
						else:
							echo "<ul><li><a href=''>" . __( 'Create menu to show it here', 'jgambling' ) . "</a></li></ul>";
						endif;
					else:
						echo notice();
					endif;
					?>
				</div>
				<div class="social">
					<?php
					$vk = carbon_get_theme_option( 'vk' );
					$fb = carbon_get_theme_option( 'fb' );
					?>
					<?php if ( $vk ): ?>
						<a href="<?php echo $vk; ?>" target="_blank">
							<img alt="vkontakte"
							     src="<?php echo get_template_directory_uri() ?>/assets/img/social1.png"></a>
					<?php endif; ?>

					<?php if ( $fb ): ?>
						<a href="<?php echo $fb; ?>" target="vk">
							<img alt="facebook" src="<?php echo get_template_directory_uri() ?>/assets/img/social2.png"></a>
					<?php endif; ?>
				</div>
				<div class="menu-button"></div>
			</div>
		</div>
	</header>
	<?php if ( ! carbon_get_theme_option( 'hide_buttom' ) ): ?>
		<nav class="top-menu">
			<ul class="flex">
				<?php
				$ret = strip_tags( wp_nav_menu( array(
					'theme_location' => 'bottom',
					'echo'           => false
				) ), "<a><li>" );
				if ( $ret ):
					echo $ret;
				else:
					echo "<li><a href=''>" . __( 'Create menu to show it here', 'jgambling' ) . "</a></li></ul>";
				endif;
				?>
			</ul>
		</nav>
	<?php else: ?>
	<style>
		.header {
			margin-bottom: 25px;
		}
	</style>
<?php endif; ?>