<?php
declare(strict_types=1);

namespace ItalyStrap\Asset;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Config\Config;
use ItalyStrap\Finder\Finder;

class Editor implements SubscriberInterface {


	/**
	 * @var Config
	 */
	private $config;
	/**
	 * @var Finder
	 */
	private $finder;

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_before_loop' - 20
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return array(
			/**
			 * Per ora la eseguo da qui
			 * in futuro valutare posto migliore
			 */
//			'italystrap_theme_load'	=> 'add_editor_styles',
			'admin_init'	=> 'add_editor_styles',
		);
	}

	/**
	 * Editor constructor.
	 * @param Config $config
	 * @param Finder $finder
	 */
	public function __construct( Config $config, Finder $finder ) {
		$this->config = $config;
		$this->finder = $finder;
	}

	/**
	 * Add Custom CSS in visual editor
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_editor_style
	 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
	 *
	 * Leggere qui perché forse c'è un problema con i font, non prende il path giusto
	 * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
	 * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
	 */
	public function add_editor_styles() {

		$this->finder->names([
			'../css/editor-style.css',
			'../assets/css/editor-style.css',
		]);

		/** @var \SplFileInfo $editor_style */
		$editor_style = '';
		foreach ( $this->finder as $file ) {
			$editor_style = $file;
			break;
		}

//		$style_url = \file_exists( $this->config->get( 'CHILDPATH' ) . '/css/editor-style.css' )
//			? $this->config->get( 'STYLESHEETURL' ) . '/assets/css/editor-style.css'
//			: $this->config->get( 'TEMPLATEURL' ) . '/assets/css/editor-style.css';

		/**
		 * @TODO In fase di test bisogna verificare sia il papt to url per il child
		 *       che per il parent theme, qui per esempio prendo tutto dal child
		 *       e dovrebbe fare la fallback sul parent in caso il child non
		 *       sia installato
		 */
		$style_url = \str_replace(
			\strval( \realpath( $this->config->get( 'CHILDPATH' ) ) ), // Search
			$this->config->get( 'STYLESHEETURL' ), // Replace
			$editor_style->getRealPath()
		);

		/**
		 * @TODO Make sure URL has not back slashes
		 */
		$style_url = \str_replace('\\', '/', $style_url);

		$arg = \apply_filters( 'italystrap_visual_editor_style', [ $style_url ] );

		\add_editor_style( $arg );
	}
}
