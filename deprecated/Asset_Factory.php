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

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Config\Config;
use function ItalyStrap\Config\get_config_file_content;

/**
 * Asset_Loader
 */
class Asset_Factory implements SubscriberInterface {

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return [
			'wp_enqueue_scripts'	=> [
				'function_to_add'	=> 'add_style_and_script',
				// 'priority'			=> 9999999999, // Priorità da testare
			],
			'script_loader_src'		=> [
				'function_to_add'	=> 'jquery_local_fallback',
				'priority'			=> 100, // Priorità da testare
				'accepted_args'		=> 2,
			],
			'wp_footer'				=> 'jquery_local_fallback',
		];
	}

	/**
	 * @var Style
	 */
	private $style;

	/**
	 * @var Script
	 */
	private $script;

//	public function __construct( Config $config ) {
//		$this->config = $config;
//	}

	/**
	 * Init script and style
	 * @todo Asset url from manifest file https://github.com/craigsimps/generico-asset-handler/blob/master/src/Asset.php
	 */
	function add_style_and_script() {

		$this->style = new Style( new Config( get_config_file_content('theme/styles') ) );
		$this->style->register_all();

		$this->script = new Script( new Config( get_config_file_content('theme/scripts') ) );
		$this->script->register_all();
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
}
