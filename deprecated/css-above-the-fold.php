<?php
/**
 * This functions are experimental
 */
function italystrap_css_above_the_fold(){

	echo "<style type='text/css'>";
	echo "*, ::before, ::after { box-sizing: border-box; }
html { font-family: sans-serif; font-size: 62.5%; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); }
body { padding-bottom: 40px; color: rgb(51, 51, 51); margin: 0px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.428571429; background-color: rgb(255, 255, 255); }
article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary { display: block; }
.navbar-wrapper { position: relative; top: 0px; left: 0px; right: 0px; z-index: 10; margin-top: 20px; }";


	if ( is_home() || is_front_page() ){
		echo "";
	}
	echo "";
	echo "</style>\n";
}
add_action('wp_head', 'italystrap_css_above_the_fold', 1);