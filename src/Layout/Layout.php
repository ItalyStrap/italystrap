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
			'wp_loaded'			=> array(
				'function_to_add'	=> 'init',
			),
		);
	}

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
	 * Init the constructor
	 *
	 * @param array $theme_mod Theme mods array.
	 */
	function __construct( array $theme_mods = array() ) {
	// function __construct( \ItalyStrap\Config\Config $config ) {
		$this->theme_mods = $theme_mods;
		// $this->theme_mods = $config->all();
	}

	/**
	 * Get the ID
	 * @see Template::get_the_ID()
	 *
	 * @return int The current content ID
	 */
	public function get_the_ID() {

		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

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
	public function get_post_type( $post = null ) {

		return get_post_type( $post );
	}

	/**
	 * Init
	 */
	public function init() {

		$this->classes = array(
			'full_width'				=> array(
				'content'			=> $this->theme_mods['full_width'],
				'sidebar'			=> '',
				'sidebar_secondary'	=> '',
			),
			'content_sidebar'			=> array(
				'content'			=> $this->theme_mods['content_class'],
				'sidebar'			=> $this->theme_mods['sidebar_class'],
				'sidebar_secondary'	=> '',
			),
			'content_sidebar_sidebar'	=> array(
				'content'			=> 'col-md-7',
				'sidebar'			=> 'col-md-3',
				'sidebar_secondary'	=> 'col-md-2',
			),
			'sidebar_content_sidebar'	=> array(
				'content'			=> 'col-md-7 col-md-push-3',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2',
			),
			'sidebar_sidebar_content'	=> array(
				'content'			=> 'col-md-7 col-md-push-5',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2 col-md-pull-10',
			),
			'sidebar_content'			=> array(
				'content'			=> $this->theme_mods['content_class'] . '  col-md-push-4',
				'sidebar'			=> $this->theme_mods['sidebar_class'] . '  col-md-pull-8',
				'sidebar_secondary'	=> '',
			),
		);

		$this->schema = array(
			'front-page'	=> is_home() ? 'https://schema.org/WebSite' : 'https://schema.org/Article',
			'page'			=> 'https://schema.org/Article',
			'single'		=> 'https://schema.org/Article',
			'search'		=> 'https://schema.org/SearchResultsPage',
		);

	}

	/**
	 * Get the layout settings
	 *
	 * @todo Need more tests
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_layout_settings() {

		static $setting;
		$setting = $this->theme_mods['site_layout'];

		// delete_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );
		// delete_post_meta_by_key( '_italystrap_layout_settings' );

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		// if ( ! $setting ) {
		// 	$setting = $this->theme_mods['site_layout'];
		// }

		if ( is_singular() ) {
			$page_layout = get_post_meta( $this->get_the_ID(), '_italystrap_layout_settings', true );
			$setting = $page_layout ? $page_layout : 'content_sidebar';
		}

		// if ( empty( $setting ) ) {
		// 	$setting = $this->theme_mods['site_layout'];
		// }

		/**
		 * Backward compatibility with the front-page template
		 * old PAGE_ON_FRONT === $this->get_the_ID() && empty( $setting ) 
		 */
		// if ( \ItalyStrap\Core\is_static_front_page() && empty( $setting ) ) {
		// 	return 'full_width';
		// }

		/**
		 * Momentaneamente nella pagina di ricerca ritorno il layout con sidebar
		 * perché se il risultato è un solo articolo mi prendeva l'ID
		 * dell'articolo cercato e mi ritornava il layout assegnato ad esso.
		 * Fare ulteriori test in futuro e appena creo i settings globali
		 * anche per questa pagina allora dovrà bypassare questo problema.
		 */
		// if ( is_search() ) {
		// 	return 'content_sidebar';
		// }

		// if ( empty( $setting ) ) {
		// 	return 'content_sidebar';
		// }

		return $setting;
	}

	/**
	 * Set the content CSS class for layout.
	 *
	 * @param  array  $attr    The array with all HTML attributes to render.
	 * @param  string $context The context in wich this functionis called.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 *
	 * @return string        Return the new array
	 */
	public function set_content_class( array $attr, $context, $args ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['content'];

		if ( isset( $this->schema[ CURRENT_TEMPLATE_SLUG ] ) ) {
			$attr['itemtype'] = $this->schema[ CURRENT_TEMPLATE_SLUG ];
		} else {
			$attr['itemtype'] = 'https://schema.org/WebSite';
		}

		return $attr;
	}

	/**
	 * Set sidebar CSS class
	 *
	 * @param  array  $attr    The array with all HTML attributes to render.
	 * @param  string $context The context in wich this functionis called.
	 * @param  null   $args    Optional. Extra arguments in case is needed.
	 *
	 * @return string        Return the new array
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
	 * @return string        Return the new array
	 */
	public function set_sidebar_secondary_class( array $attr, $context, $args ) {

		$attr['class'] = $this->classes[ $this->get_layout_settings() ]['sidebar_secondary'];
		return $attr;
	
	}
}
