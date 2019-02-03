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
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Asset;

use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Config\Config;

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
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			// 'wp_print_styles'		=> array( // This action fires after 'wp_enqueue_scripts' useful for deregistering assets added in a wrong place like jetpacl does.
			// 	'function_to_add'	=> 'maybe_deregister_styles_on_wp_print_styles',
			// 	'priority'			=> 9999999999, // Priorità da testare
			// ),
			'wp_enqueue_scripts'	=> array(
				'function_to_add'	=> 'add_style_and_script',
				// 'priority'			=> 9999999999, // Priorità da testare
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

		if ( SCRIPT_DEBUG ) {

			$ver = rand( 0, 100000 );
			// $ver = filemtime($file);
			// $suffix = '';
			// $dev_dir = 'src/'; // Sistemare il path corretto per i font
		}

		$style_file_url = TEMPLATEURL . '/css/' . $dev_dir . 'custom.css';
		$style_file_path = PARENTPATH . '/css/' . $dev_dir . 'custom.css';

		if ( file_exists( CHILDPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' ) ) {
			$style_file_url = STYLESHEETURL . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css';
			$style_file_path = CHILDPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css';
		} elseif ( file_exists( CHILDPATH . '/css/' . $dev_dir . 'custom.css' ) ) {
			$style_file_url = STYLESHEETURL . '/css/' . $dev_dir . 'custom.css';
			$style_file_path = CHILDPATH . '/css/' . $dev_dir . 'custom.css';
		}

//		d( get_theme_file_uri( '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' ) );

		$config_styles = [
			[
				'handle'	=> CURRENT_TEMPLATE_SLUG,
				'file'		=> $style_file_url,
				'version'	=> filemtime( $style_file_path ),
				'media'		=> null,
			],
		];

		$this->style = new Style( new Config( $config_styles, [] ) );
		$this->style->register_all();


		$script_file_url = TEMPLATEURL . '/js/custom' . $min . '.js';
		$script_file_path = PARENTPATH . '/js/custom' . $min . '.js';

		if ( file_exists( CHILDPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' ) ) {
			$script_file_url = STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js';
			$script_file_path = CHILDPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js';
		} elseif ( file_exists( CHILDPATH . '/js/custom' . $min . '.js' ) ) {
			$script_file_url = STYLESHEETURL . '/js/custom' . $min . '.js';
			$script_file_path = CHILDPATH . '/js/custom' . $min . '.js';
		}

		$config_scripts = [
			[
				'handle'		=> 'jquery',
				'file'			=> '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
				'deps'			=> false,
				'version'		=> $ver,
				'in_footer'		=> true,
				'pre_register'	=> true,
				'deregister'	=> true, // This will deregister previous registered jQuery.
			],
			[
				'handle'		=> CURRENT_TEMPLATE_SLUG,
				'file'			=> $script_file_url,
				'deps'			=> ['jquery'],
				'version'		=> filemtime( $script_file_path ),
				'in_footer'		=> true,

				/**
				 * For now the localize object is set only if the script is not deregister
				 * and if is appendend to the config array of the script to load.
				 */
				'localize'		=> [
					'object_name'	=> 'pluginParams',
					'params'		=> [
						'ajaxurl'		=> admin_url( '/admin-ajax.php' ),
						'ajaxnonce'		=> wp_create_nonce( 'ajaxnonce' ),
						// 'api_endpoint'	=> site_url( '/wp-json/rest/v1/' ),
					],
				],
			],
			[
				'handle'		=> 'comment-reply',
				'load_on'		=> 'ItalyStrap\Core\is_comment_reply',
			],
		];

		$this->script = new Script( new Config( $config_scripts, [] ) );
		$this->script->register_all();
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
