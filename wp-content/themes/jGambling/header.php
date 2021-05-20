
<!DOCTYPE html>
<html>
<head>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(68638699, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/68638699" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    <title><?php wp_title( '' ) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?php wp_head(); ?>
    <?php
    $b_static         = carbon_get_theme_option( 'other' );
    $b_hover          = carbon_get_theme_option( 'other_hover' );
    $color_star       = carbon_get_theme_option( 'color-stars' );
    $bonus_back       = carbon_get_theme_option( 'bonus_back' );
    $bonus_text_color = carbon_get_theme_option( 'bonus_text_color' );
    if ( $b_static || $b_hover ) {
        echo "<style>";
        if ( $b_static ) {
    		echo '.custom_color{background: ' . $b_static . '! important;}';
		}
		if ( $b_hover ) {
			echo '.custom_color:hover{background: ' . $b_hover . '! important;}';
		}
		echo "</style>";
	}
	if ( $color_star ) {
		echo "<style>";
		echo 'span.checked:before{color: ' . $color_star . '! important;}';
		echo "</style>";
	}

	if ( $bonus_back ) {
		echo "<style>";
		echo '.bonus-list .item{background: ' . $bonus_back . '! important;}';
		echo "</style>";
	}
	if ( $bonus_text_color ) {
		echo "<style>";
		echo '.bonus-list .item .b1.upper a{color: ' . $bonus_text_color . '! important;} ';
		echo '.bonus-list .item .name{color: ' . $bonus_text_color . '! important;} ';
		echo '.bonus-list .item p{color: ' . $bonus_text_color . '! important;} ';
		echo "</style>";
	}
	$header_code = carbon_get_theme_option( 'header_code' );
	if ( $header_code ) {
		echo $header_code;
	}
	?>
</head>
<body class="jgambling_theme">
<?php
if ( carbon_get_theme_option( 'header_style' ) == 'v2' ) {
	?>
    <style>
        .footer .wrap {
            top: 190px;
            position: initial;
        }

        .footer {
            top: 190px;
        }

        .wrap {
            position: relative;
            top: 190px;
        }
    </style>
	<?php
	$height = carbon_get_theme_option( 'v2_height' );
	if ( $height ):
		?>
        <style>
            .headers {
                height: <?php echo $height; ?>px;
            }
        </style>

	<?php endif;
	include "parts/header/header-v2.php";

} else {
	include "parts/header/header-v1.php";
} ?>

<?php
if ( is_front_page() ):
$home_img  = carbon_get_theme_option( 'banner_img' );
$home_src  = wp_get_attachment_url( $home_img );
$home_link = carbon_get_theme_option( 'banner_link' ); ?>
<?php if ( $home_img AND $home_link ): ?>
<div class="top-banner">
    <a href="<?php echo $home_link; ?>" target="_blank" rel="nofollow">
        <img alt="banner" class="lazy" data-src="<?php echo $home_src; ?>"></a>
</div>
<?php endif;
endif;
?>
