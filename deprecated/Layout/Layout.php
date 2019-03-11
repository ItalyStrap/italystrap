<?php
/**
 * Layout API: This class handle the layout of the theme, by default the theme uses Twitter Bootstrap for the layout but you can use the CSS framework you want simply change the value of 
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Layout;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\Config\Config_Interface;

/**
 * Layout Class
 */
class Layout implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_content_attr'           - 10
	 * @hooked 'italystrap_sidebar_attr'           - 10
	 * @hooked 'italystrap_sidebar_secondary_attr' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_content_attr'			=> array(
				'function_to_add'	=> 'set_content_class',
				'accepted_args'		=> 3
			),
			'italystrap_sidebar_attr'			=> array(
				'function_to_add'	=> 'set_sidebar_class',
				'accepted_args'		=> 3
			),
			'italystrap_sidebar_secondary_attr'	=> array(
				'function_to_add'	=> 'set_sidebar_secondary_class',
				'accepted_args'		=> 3
			),
			'italystrap_post_thumbnail_size'			=> array(
				'function_to_add'	=> 'post_thumbnail_size',
			),
			'wp_loaded'			=> array(
				'function_to_add'	=> 'init',
			),
		);
	}

	/**
	 * Config
	 *
	 * @var Config_Interface
	 */
	private $config;

	/**
	 * Theme mods
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * Layout classes for page elements.
	 *
	 * @var array
	 */
	private $classes = array();

	/**
	 * Layout classes for page elements.
	 *
	 * @var array
	 */
	private $schema = array();

	/**
	 * Init the constructor
	 *
	 * @param array $theme_mod Theme mods array.
	 */
	function __construct( array $theme_mods = array(), Config_Interface $config = null ) {
		$this->config = $config;
		$this->theme_mods = $theme_mods;
		// $this->theme_mods = $config->all();
	}

	/**
	 * Init
	 */
	public function init() {
		// $this->delete_layout();

		$this->classes = [
			'full_width'				=> [
				'content'			=> $this->theme_mods['full_width'],
				'sidebar'			=> '',
				'sidebar_secondary'	=> '',
			],
			'content_sidebar'			=> [
				'content'			=> $this->theme_mods['content_class'],
				'sidebar'			=> $this->theme_mods['sidebar_class'],
				'sidebar_secondary'	=> '',
			],
			'content_sidebar_sidebar'	=> [
				'content'			=> 'col-md-7',
				'sidebar'			=> 'col-md-3',
				'sidebar_secondary'	=> 'col-md-2',
			],
			'sidebar_content_sidebar'	=> [
				'content'			=> 'col-md-7 col-md-push-3',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2',
			],
			'sidebar_sidebar_content'	=> [
				'content'			=> 'col-md-7 col-md-push-5',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2 col-md-pull-10',
			],
			'sidebar_content'			=> [
				'content'			=> $this->theme_mods['content_class'] . '  col-md-push-4',
				'sidebar'			=> $this->theme_mods['sidebar_class'] . '  col-md-pull-8',
				'sidebar_secondary'	=> '',
			],
		];
	}

	/**
	 * Get the layout settings
	 *
	 * @todo Need more tests
	 *
	 * @return string Return the array with template part settings.
	 */
	public function get_layout_settings() {

		return (string) apply_filters( 'italystrap_get_layout_settings', $this->config->get( 'site_layout', 'content_sidebar' ) );
	}

	/**
	 * Set the content CSS class for layout.
	 *
	 * @param  array  $attr    The array with all HTML attributes to render.
	 * @param  string $context The context in wich this functionis called.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 *
	 * @return array           Return the new array
	 */
	public function set_content_class( array $attr, $context, $args ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['content'];

		return $attr;
	}

	/**
	 * Set sidebar CSS class
	 *
	 * @param  array  $attr    The array with all HTML attributes to render.
	 * @param  string $context The context in wich this functionis called.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 *
	 * @return array           Return the new array
	 */
	public function set_sidebar_class( array $attr, $context, $args ) {
		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['sidebar'];
		return $attr;
	}

	/**
	 * Set sidebar CSS class
	 *
	 * @param  array  $attr    The array with all HTML attributes to render.
	 * @param  string $context The context in wich this functionis called.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 *
	 * @return array           Return the new array
	 */
	public function set_sidebar_secondary_class( array $attr, $context, $args ) {
		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['sidebar_secondary'];
		return $attr;
	}

	/**
	 * post_thumbnail_size
	 *
	 * @param  string $size The post_thumbnail_size.
	 * @return string       The post_thumbnail_size full if layout is fullwidth
	 */
	public function post_thumbnail_size( $size ) {
		if ( 'full_width' === $this->get_layout_settings() ) {
			return 'full';
		}

		return $size;
	}

	/**
	 * Get the ID
	 *
	 * @see Template::get_the_ID()
	 *
	 * @return int The current content ID
	 */
	private function get_the_ID() {

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		/**
		 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post(). twentyseventeen
		 * get_queried_object_id()
		 */
		return get_queried_object_id();
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
	private function get_post_type( $post = null ) {
		return get_post_type( $post );
	}

	/**
	 * Delete layout
	 */
	private function delete_layout() {
		delete_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );
		delete_post_meta_by_key( '_italystrap_layout_settings' );
		remove_theme_mod( 'site_layout' );
	}
}
