<?php
/**
 * Template API: Template Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Templates;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Template Class
 */
class Template_Base implements Template_Interface {

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
	 *File name for the view
	 *
	 * @var string
	 */
	protected $file_name = '';

	/**
	 * Theme mods
	 *
	 * @var array
	 */
	protected static $mods = array();
	protected static $post_content_template = array();
	protected static $count = 0;

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	public function __construct( array $theme_mods = array() ) {

		if ( empty( self::$mods ) ) {
			self::$mods = $theme_mods;
		}
		$this->theme_mod = self::$mods;

		if ( empty( self::$post_content_template ) ) {
			self::$post_content_template = explode( ',', $this->theme_mod['post_content_template'] );
		}

		/**
		 * Credits:
		 * @link https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace
		 * @php54
		 * $this->class_name =  ( new \ReflectionClass( $this ) )->getShortName();
		 */
		$class_name = new \ReflectionClass( $this );
		$this->class_name =  $class_name->getShortName();
		$this->class_name = strtolower( $this->class_name );

		$this->template_dir = apply_filters( 'italystrap_template_dir', 'templates' );
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		if ( empty( $this->file_name ) ) {
			throw new \Exception('You have to register the file name of the view.');
		}

		$this->get_template_part( $this->template_dir . DIRECTORY_SEPARATOR . $this->file_name );
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

		if ( ! is_singular() ) {
			return (array) self::$post_content_template;
		}

		return (array) get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
	}

	/**
	 * Load a template part into a template
	 *
	 * Makes it easy for a theme to reuse sections of code in a easy to overload way
	 * for child themes.
	 *
	 * Includes the named template part for a theme or if a name is specified then a
	 * specialised part will be included. If the theme contains no {slug}.php file
	 * then no template will be included.
	 *
	 * The template is included using require, not require_once, so you may include the
	 * same template part multiple times.
	 *
	 * For the $name parameter, if the file is called "{slug}-special.php" then specify
	 * "special".
	 *
	 * @since 4.0.0
	 *
	 * @see get_template_part() - wp-includes/general-template.php
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 */
	protected function get_template_part( $slug, $name = null, $load = false ) {
		/**
		 * Fires before the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, `$slug`, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 3.0.0
		 *
		 * @param string      $slug The slug name for the generic template.
		 * @param string|null $name The name of the specialized template.
		 */
		do_action( "italystrap_get_template_part_{$slug}", $slug, $name );

		$templates = array();
		$name = (string) $name;
		if ( '' !== $name )
			$templates[] = "{$slug}-{$name}.php";

		$templates[] = "{$slug}.php";

		if ( $load ) {
			locate_template( $templates, $load, false );
			return;
		}

		require( locate_template( $templates, $load, false ) );
	}
}
