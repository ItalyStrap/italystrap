<?php
/**
 * Add HTML5 Boilerplate code for google analytics
 * Insert your ID in Option Theme admin panel
 * Print code only if value exist
 * @return string Return google analytics code
 */
function italystrap_add_google_analytics(){

	$analytics = (isset($GLOBALS['italystrap_options']['analytics']) && $GLOBALS['italystrap_options']['analytics'] !== 0 ) ? esc_textarea($GLOBALS['italystrap_options']['analytics']) : '' ;

	if( !is_preview() && !is_admin() && $analytics ){

		?>

<!-- Google Analytics from HTML5 Boilerplate  -->
<script>(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;e=o.createElement(i);r=o.getElementsByTagName(i)[0];e.src='https://www.google-analytics.com/analytics.js';r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));ga('create','<?php echo $analytics; ?>','auto');ga('send','pageview');ga('set', 'anonymizeIp', true);</script>
		<?php

		}

}
add_action('wp_footer', 'italystrap_add_google_analytics', 99999);