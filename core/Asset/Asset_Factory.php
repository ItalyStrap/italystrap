<?php
/**
 * Asset_Loader API
 *
 * This class load all theme assets enqueued.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package Italystrap
 */

namespace ItalyStrap\Core\Asset;

use ItalyStrap\Core\Event\Subscriber_Interface;

/**
 * Asset_Loader
 */
class Asset_Factory implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'				=> 'method_name',
			'wp_enqueue_scripts'	=> 'add_style_and_script',
			'script_loader_src'	=> array(
				'function_to_add'	=> 'jquery_local_fallback',
				'priority'			=> 10,
				'accepted_args'		=> 2,
			),
			'wp_footer'	=> 'jquery_local_fallback',
		);
	}

	/**
	 * [$var description]
	 *
	 * @var Asset
	 */
	private $script;

	/**
	 * [$var description]
	 *
	 * @var Asset
	 */
	private $style;

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct() {
		// array $theme_mod, Asset $script, Asset $style
		// $this->script = $script;
		// $this->style = $style;
	}

	/**
	 * Init script and style
	 */
	function add_style_and_script() {

		$min = '.min';

		/**
		 * Avoid caching script
		 *
		 * @var int
		 */
		$ver = null;

		$suffix = '.min';

		$dev_dir = '';

		if ( WP_DEBUG ) {

			$ver = rand( 0, 100000 );
			// $suffix = '';
			// $dev_dir = 'src/'; // Sistemare il path corretto per i font

		}

		$config_styles = array(
			array(
				'handle'	=> CURRENT_TEMPLATE_SLUG,
				'file'		=>
					file_exists( STYLESHEETPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' )
					? STYLESHEETURL . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css'
					: STYLESHEETURL . '/css/' . $dev_dir . 'custom.css',
				'version'	=> $ver,
				'media'		=> null,
			),
		);

		$this->style = new Style( $config_styles );
		$this->style->register();

		$config_scripts = array(
			array(
				'handle'		=> 'jquery',
				'file'			=> 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
				'deps'			=> false,
				'version'		=> $ver,
				'in_footer'		=> true,
				'pre_register'	=> true,
				'deregister'	=> true, // This will deregister previous registered jQuery.
			),
			array(
				'handle'		=> CURRENT_TEMPLATE_SLUG,
				'file'			=>
					file_exists( STYLESHEETPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' )
					? STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js'
					: STYLESHEETURL . '/js/custom' . $min . '.js',
				'deps'			=> array( 'jquery' ),
				'version'		=> $ver,
				'in_footer'		=> true,
			),
			array(
				'handle'		=> 'comment-reply',
				'load_on'		=> 'ItalyStrap\Core\is_comment_reply',
			),
		);

		$this->script = new Script( $config_scripts );
		$this->script->register();

		/**
		 * If CDN is down load from callback
		 */
		// add_filter( 'script_loader_src', __NAMESPACE__ . '\jquery_local_fallback', 10, 2 );
	}

	/**
	 * Print fallback if google CDN is out
	 *
	 * @link http://wordpress.stackexchange.com/a/12450
	 * @link https://github.com/roots/roots/blob/master/lib/scripts.php
	 *
	 * @since 1.0.0
	 *
	 * @param  string $src    jQuery src if true = $add_jquery_fallback.
	 * @param  string $handle Name of handle.
	 * @return string         Return jQuery fallback if true = $add_jquery_fallback
	 */
	function jquery_local_fallback( $src, $handle = null ) {

		static $add_jquery_fallback = false;

		if ( $add_jquery_fallback ) {

			/**
			 * @todo document.write è da sostituire.
			 */
			echo '<script>window.jQuery || document.write(\'<script src="' . TEMPLATEURL . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
			$add_jquery_fallback = false;

		}

		if ( 'jquery' === $handle ) {
			$add_jquery_fallback = true;
		}

		return $src;
	}

	/**
	 * Hook into the 'wp_enqueue_scripts' action
	 */
	// add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_style_and_script' );
	// add_action( 'wp_footer', __NAMESPACE__ . '\jquery_local_fallback' );
}
