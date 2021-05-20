<?php
if ( carbon_get_theme_option( 'logo' ) ):
	$logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
else:
	$logo = get_template_directory_uri() . '/assets/img/logo.png';
endif;
$menu_v2 = carbon_get_theme_option( 'menucolor_v2' );
if ( $menu_v2 ) {
	echo "<style>";
	echo '.headers{background-color: ' . $menu_v2 . '! important;}';
	echo "</style>";
}
//
?>
<?php if ( ! carbon_get_theme_option( 'v2_height' ) ): ?>
    <style>
        .breadcrumbs__current {
            color: #acaba7;
        }

        .breadcrumbs__separator, .navi a.breadcrumbs__link {
            color: #fac833;
        }
    </style>
<?php endif; ?>
<headers class="headers">
    <div class="container">
        <div class="headers-top">
            <a class="logo__link" href="<?php echo home_url( '/' ) ?>">
                <img class="logo__img" src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name ' ) ?>">
            </a>
			<?php if ( ! carbon_get_theme_option( 'hide_search' ) ): ?>
                <div class="headers-top__search">
                    <form action="/" class="hide-submit">
                        <input class="search" type="text" name="s"
                               placeholder="<?php echo __( 'Site search...', 'jgambling' ); ?>">
                        <label>
                            <input type="submit"/>
                            <svg class="svg-sprite-icon  icon-search search__icon">
                                <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/img/svg/symbol/sprite.svg#search"></use>
                            </svg>
                        </label>
                    </form>
                </div>
			<?php endif; ?>
            <div class="social">
				<?php
				$vk = carbon_get_theme_option( 'vk' );
				$fb = carbon_get_theme_option( 'fb' );
				$tw = carbon_get_theme_option( 'tw' );
				?>
				<?php if ( $fb ): ?>
                    <a class="social__link" href="<?php echo $fb; ?>">
                        <img class="social__item"
                             src="<?php echo get_template_directory_uri() ?>/assets/img/facebook.png">
                    </a>
				<?php endif; ?>
				<?php if ( $vk ): ?>
                    <a class="social__link" href="<?php echo $vk; ?>">
                        <img class="social__item" src="<?php echo get_template_directory_uri() ?>/assets/img/vk.png">
                    </a>
				<?php endif; ?>
				<?php if ( $tw ): ?>
                    <a class="social__link" href="<?php echo $tw; ?>">
                        <img class="social__item"
                             src="<?php echo get_template_directory_uri() ?>/assets/img/twitter.png">
                    </a>
				<?php endif; ?>
            </div>
        </div>
        <div class="headers-body">
            <a href="">
                <svg class="svg-sprite-icon  icon-home headers-body__icon">
                    <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/img/svg/symbol/sprite.svg#home"></use>
                </svg>
            </a>
            <div class="sandwich">
                <div class="sandwich__line sandwich__line--top"></div>
                <div class="sandwich__line sandwich__line--middle"></div>
                <div class="sandwich__line sandwich__line--bottom"></div>
            </div>
            <div class="mobiles-menu">
				<?php wp_nav_menu( array(
					'theme_location' => 'top',
					'fallback_cb'    => 'Main menu',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new MOBILE_Walker_Nav_Menu()
				) ); ?>
            </div>
            <nav class="headers-body__menu">
                <ul class="headers-body__list">
					<?php wp_nav_menu( array(
						'theme_location' => 'top',
						'fallback_cb'    => 'Main menu',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'walker'         => new PC_Walker_Nav_Menu()
					) ); ?>
                </ul>
            </nav>
        </div>
    </div>
</headers>
<div class="wrap">