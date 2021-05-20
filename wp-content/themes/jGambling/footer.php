<footer class="footer">
    <div class="wrap">
        <div class="flex">
    		<?php dynamic_sidebar( 'footer1' ) ?>
			<?php dynamic_sidebar( 'footer2' ) ?>
			<?php dynamic_sidebar( 'footer3' ) ?>
			<?php dynamic_sidebar( 'footer4' ) ?>
			<?php dynamic_sidebar( 'footer5' ) ?>
        </div>
    </div>
</footer>
<?php wp_footer();
$footer_code = carbon_get_theme_option( 'footer_code' );
if ( $footer_code ) {
	echo $footer_code;
}
?>
<!--LiveInternet counter--><a href="//www.liveinternet.ru/click"
target="_blank"><img id="licntC366" width="31" height="31" style="border:0" 
title="LiveInternet"
src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7"
alt=""/></a><script>(function(d,s){d.getElementById("licntC366").src=
"//counter.yadro.ru/hit?t44.6;r"+escape(d.referrer)+
((typeof(s)=="undefined")?"":";s"+s.width+"*"+s.height+"*"+
(s.colorDepth?s.colorDepth:s.pixelDepth))+";u"+escape(d.URL)+
";h"+escape(d.title.substring(0,150))+";"+Math.random()})
(document,screen)</script><!--/LiveInternet-->
</body>
</html>
