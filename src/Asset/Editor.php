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

//		$this->finder->in(
//			[
//				$this->config->get( 'STYLESHEETURL' ),
//				$this->config->get( 'TEMPLATEURL' )
//			]
//		);

		d( $this->finder->firstFile( '../css/editor-style', 'css' ) );

		$style_url = \file_exists( $this->config->get( 'CHILDPATH' ) . '/css/editor-style.css' )
			? $this->config->get( 'STYLESHEETURL' ) . '/css/editor-style.css'
			: $this->config->get( 'TEMPLATEURL' ) . '/css/editor-style.css';

		$arg = \apply_filters( 'italystrap_visual_editor_style', [ $style_url ] );

		\add_editor_style( $arg );
	}
}
