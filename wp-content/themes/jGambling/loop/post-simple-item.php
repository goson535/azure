<div class="item">
    <a href="<?php echo get_the_permalink(); ?>">
        <div class="darkened">
            <img src="<?php echo aq_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 200, 200, true, true, true ); ?>"
                 alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>">
        </div>
    </a>
    <div class="content" style="z-index: 99999;">
        <div class="date"><?php echo get_the_author()?> &nbsp; <?php echo get_the_date('d.m.Y')?></div>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
    </div>
</div>