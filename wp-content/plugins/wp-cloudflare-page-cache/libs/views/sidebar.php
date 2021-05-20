<?php $stars = '<span class="wporg-ratings rating-stars"><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important; font-size: 15px !important; width: auto !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important; font-size: 15px !important; width: auto !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important; font-size: 15px !important; width: auto !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important; font-size: 15px !important; width: auto !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important; font-size: 15px !important; width: auto !important;"></span></span>'; ?>

<div id="swcfpc_sidebar">

    <div class="swcfpc_sidebar_widget">

        <h3><?php _e("Do you want this plugin to remain free?", 'wp-cloudflare-page-cache'); ?></h3>

        <p><?php _e('As you know this plugin requires many hours of development and maintenance, not to mention the support that takes several hours of my day every day.', 'wp-cloudflare-page-cache'); ?></p>
        <p><?php printf( __('If you want this plugin to remain free, drop a %s review on %s and become a supporter.', ''), "<a href='".esc_url(SWCFPC_PLUGIN_REVIEWS_URL."?rate=5#new-post")."'>$stars</a>", "<a href='".esc_url(SWCFPC_PLUGIN_REVIEWS_URL."?rate=5#new-post")."'>Wordpress.org</a>"); ?></p>
        <p><?php _e('If you wish to donate a coffee,', 'wp-cloudflare-page-cache'); ?> <a href="https://www.speedywp.it/blog/" target="_blank"><?php _e('go to this page', 'wp-cloudflare-page-cache'); ?></a> <?php _e('and click on the button', 'wp-cloudflare-page-cache'); ?> <em><strong>Donate now with Stripe</strong></em>.</p>
        <p><?php _e('Thanks a lot in advance!', 'wp-cloudflare-page-cache'); ?></p>

    </div>

    <div class="swcfpc_sidebar_widget">

        <h3><?php _e("About the author and support", 'wp-cloudflare-page-cache'); ?></h3>

        <img src="<?php echo SWCFPC_PLUGIN_URL.'assets/img/salvatore-fresta.jpg'; ?>" alt="Salvatore Fresta" />

        <p><?php _e('My name is Salvatore Fresta and I\'m an italian web performance specialist and a senior developer.', 'wp-cloudflare-page-cache'); ?></p>
        <p><?php _e('I\'m the founder of the first italian blog about Wordpress performance', 'wp-cloudflare-page-cache'); ?> <a href="https://www.speedywp.it" target="_blank">speedywp.it</a> <?php _e('and the co-founder of the italian agency ', 'wp-cloudflare-page-cache'); ?> <a href="https://www.squeezemind.it" target="_blank">SqueezeMind</a>.</p>
        <p><?php printf( __('If you have any issues with this plugin, drop me a line via email to %s.', 'wp-cloudflare-page-cache'), '<strong>salvatorefresta [at] gmail.com</strong>'); ?>.</p>

        <a href="https://www.speedywp.it" target="_blank"><img src="<?php echo SWCFPC_PLUGIN_URL.'assets/img/speedy-wp.jpg'; ?>" alt="Speedy Wordpress" /></a>
        <a href="https://www.squeezemind.it" target="_blank"><img src="<?php echo SWCFPC_PLUGIN_URL.'assets/img/squeezemind.jpg'; ?>" alt="SqueezeMind" /></a>

    </div>

</div>