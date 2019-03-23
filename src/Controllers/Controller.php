<?php
/**
 * Template API: Template Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Controllers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Template\View_Interface;

/**
 * Template Class
 */
class Controller implements Controller_Interface {

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	protected $theme_mod = array();

	/**
	 * Default template directory
	 *
	 * @var string
	 */
	protected $template_dir = '';

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = '';

	/**
	 * @var string
	 */
	protected $class_name;

	/**
	 * Data for the view
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Theme mods
	 *
	 * @var array
	 */
	protected static $mods = array();
	protected static $post_content_template = array();
	protected static $count = 0;
	protected $view;

	/**
	 * Init the class
	 *
	 * @param array $theme_mods
	 * @param View_Interface|null $view
	 */
	public function __construct( array $theme_mods = array(), View_Interface $view = null ) {

		if ( empty( self::$mods ) ) {
			self::$mods = $theme_mods;
		}

		$this->theme_mod = self::$mods;

		if ( empty( self::$post_content_template ) ) {
			self::$post_content_template = explode( ',', $this->theme_mod['post_content_template'] );
		}

		$this->set_class_name();

//		$this->template_dir = apply_filters( 'italystrap_template_dir', 'templates' );

		$this->view = $view;

//		$this->listOfFiles = new \RecursiveIteratorIterator(
//			new \RecursiveDirectoryIterator(
//				get_stylesheet_directory() . DIRECTORY_SEPARATOR . $this->template_dir
//			)
//		);
//
//		d($this->listOfFiles);
	}

	/**
	 * Set class name
	 */
	private function set_class_name() {

		try {

			/**
			 * Credits:
			 * @link https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace
			 * @php54
			 * $this->class_name =  ( new \ReflectionClass( $this ) )->getShortName();
			 */
			$class_name = new \ReflectionClass( $this );
			$this->class_name = $class_name->getShortName();
			$this->class_name = strtolower( $this->class_name );

		} catch ( \ReflectionException $exception ) {
			echo $exception->getMessage();
		}
	}

	/**
	 * Render the output of the controller.
	 * @throws \Exception
	 */
	public function render() {

		if ( empty( $this->file_name ) ) {
			throw new \Exception('You have to register the file name of the view.');
		}

//		$template = $this->template_dir . DIRECTORY_SEPARATOR . $this->file_name;

//		echo $this->view->render( $template, $this->data );
		echo $this->view->render( $this->file_name, $this->data );
	}

	/**
	 * Get the ID
	 * @see Layout::get_the_ID()
	 *
	 * @return int        The current content ID
	 */
	protected function get_the_ID() {

		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		/**
		 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post(). twentyseventeen
		 * get_queried_object_id()
		 */

		return get_the_ID();
	}

	/**
	 * Get the post type
	 *
	 * @param int|WP_Post|null $post Post ID or post object. (Optional)
	 *                               Default is global $post.
	 *                               Default value: null
	 *
	 * @return string|false           Post type on success, false on failure.
	 */
	protected function get_post_type( $post = null ) {

		return get_post_type( $post );
	}

	/**
	 * Get the template parts settings.
	 * This methos has to be called inside a loop.
	 *
	 * @return array Return the array with template part settings.
	 */
	protected function get_template_settings() {

		static $parts = null;

		/**
		 * Cache the post_meta data
		 */
		if ( ! $parts ) {

			/**
			 * This is a little different from the layout settings because
			 * only in singular it must return the data from post_meta
			 *
			 * @var [type]
			 */
//			$parts = ! is_singular() ? (array) self::$post_content_template : (array) get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
			$parts = (array) \ItalyStrap\Factory\get_config()->get('post_content_template');
		}

		return (array) apply_filters( 'italystrap_get_template_settings', $parts );
	}

	/**
	 * Conditional tag for show or hide the template part.
	 *
	 * @param  string $part The key of the template parts settings.
	 *
	 * @return bool         Return
	 */
	protected function hide_template_part( $part ) {
		return in_array( $part, $this->get_template_settings(), true );
	}
}
