<?php
function italystrap_add_style_and_script()
	{
		global $path;

		//Carico gli stili CSS
		wp_enqueue_style( 'style',  $path . '/style.css', null, null);
		wp_enqueue_style( 'bootstrap',  $path . '/css/bootstrap.min.css', null, null);
		wp_enqueue_style( 'custom',  $path . '/css/custom.css', null, null);

		//Carico jquery da google api cdn
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, true);
		add_filter('script_loader_src', 'italystrap_jquery_local_fallback', 10, 2);
		wp_enqueue_script('jquery');

		//Carico gli script JS
		wp_enqueue_script( 'bootstrap', $path . '/js/bootstrap.min.js', array('jquery'), null,  true );
		//wp_enqueue_script('socialite', $path . '/js/socialite.js', null, null, true);
		//Activate slide on windows load
		if ( is_home() || is_front_page() ){
			wp_enqueue_script( 'home', $path . '/js/home.js', array('jquery' , 'bootstrap'), null,  true );
		}

		//if (is_single() && comments_open() && get_option('thread_comments')) {
    	//wp_enqueue_script('comment-reply');
  		//}
	}
// http://wordpress.stackexchange.com/a/12450
// https://github.com/roots/roots/blob/master/lib/scripts.php
function italystrap_jquery_local_fallback($src, $handle = null)
	{
		global $path;
		static $add_jquery_fallback = false;

		if ($add_jquery_fallback) {
			echo '<script>window.jQuery || document.write(\'<script src="' . $path . '/js/jquery-1.10.2.min.js"><\/script>\')</script>' . "\n";
			$add_jquery_fallback = false;
		}

		if ($handle === 'jquery') {
			$add_jquery_fallback = true;
		}

		return $src;
	}

if (!is_admin()) 
	{
		add_action( 'wp_enqueue_scripts', 'italystrap_add_style_and_script' ); 
		add_action( 'wp_footer', 'italystrap_jquery_local_fallback' );
	}
//http://www.emoticode.net/php/add-async-and-defer-to-script-on-wordpress.html
// function defer_parsing_of_js ( $url ) {
	// if ( FALSE === strpos( $url, '.js' ) ) return $url;
	// if ( strpos( $url, 'jquery.js' ) ) return $url;
	// return "'$url' async defer";
// }
	// add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
?>