<?php
/**
 * Asset_Loader API
 *
 * This class load all theme assets enqueued.
 *
 * @author      Enea Overclokk
 * @license     GPL-2.0+
 *
 * @link www.italystrap.com
 * @version 0.0.1-alpha
 *
 * @package ItalyStrap\Asset
 */

namespace ItalyStrap\Asset;

/**
 * Asset_Loader
 */
class Loader {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			// 'wp_print_styles'		=> array( // This action fires after 'wp_enqueue_scripts' useful for deregistering assets added in a wrong place like jetpacl does.
			// 	'function_to_add'	=> 'maybe_deregister_styles_on_wp_print_styles',
			// 	'priority'			=> 9999999999, // Priorità da testare
			// ),
			'wp_enqueue_scripts'	=> array(
				'function_to_add'	=> 'add_style_and_script',
				'priority'			=> 9999999999, // Priorità da testare
			),
			'script_loader_src'		=> array(
				'function_to_add'	=> 'jquery_local_fallback',
				'priority'			=> 100, // Priorità da testare
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
			// $ver = filemtime($file);
			// $suffix = '';
			// $dev_dir = 'src/'; // Sistemare il path corretto per i font

		}

		$config_styles = array(
			array(
				'handle'	=> CURRENT_TEMPLATE_SLUG,
				'file'		=>
					file_exists( CHILDPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' )
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
				'file'			=> '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
				'deps'			=> false,
				'version'		=> $ver,
				'in_footer'		=> true,
				'pre_register'	=> true,
				'deregister'	=> true, // This will deregister previous registered jQuery.
			),
			array(
				'handle'		=> CURRENT_TEMPLATE_SLUG,
				'file'			=>
					file_exists( CHILDPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' )
					? STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js'
					: STYLESHEETURL . '/js/custom' . $min . '.js',
				'deps'			=> array( 'jquery' ),
				'version'		=> $ver,
				'in_footer'		=> true,
				/**
				 * For now the localize object is set only if the script is not deregister
				 * and if is appendend to the config array of the script to load.
				 */
				'localize'		=> array(
					'object_name'	=> 'pluginParams',
					'params'		=> array(
						'ajaxurl'		=> admin_url( '/admin-ajax.php' ),
						'ajaxnonce'		=> wp_create_nonce( 'ajaxnonce' ),
						// 'api_endpoint'	=> site_url( '/wp-json/rest/v1/' ),
					),
				),
			),
			array(
				'handle'		=> 'comment-reply',
				'load_on'		=> 'LocalStrategy\Core\is_comment_reply',
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
	 *
	 */
	public function maybe_deregister_styles_on_wp_print_styles( $value = '' ) {
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
