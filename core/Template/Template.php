<?php
/**
 * Template API: Template Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Template;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Template Class
 */
class Template {

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	private $theme_mod = array();

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mod = array() ) {
		$this->theme_mod = $theme_mod;
	}

	/**
	 * Get the ID
	 *
	 * @return int        The current content ID
	 */
	public function get_the_ID() {
	
		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

		return get_the_ID();
	
	}

	/**
	 * [get_template_settings description]
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_template_settings() {

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		return get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
	}

	/**
	 * filter_template_include
	 *
	 * @param  array $map Array with .
	 * @return array      Return the template path
	 */
	public function filter_template_include( $map ) {
	// 	$new_map = array(
	// 		// 'single.php'	=> 'full-width.php',
	// 		'single.php'	=> array( $this, 'do_loop' ),
	// 	);
	// d( $map, CURRENT_TEMPLATE );
	// 	return $new_map;
		return $map;
	}

	/**
	 * Do Loop
	 */
	public function do_loop() {
	
		get_template_part( 'templates/loops/loop' );
	
	}

	/**
	 * Do Entry
	 */
	public function do_entry() {
	
		$file_type = get_post_type();
		// d( $file_type, CURRENT_TEMPLATE_SLUG );
		if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
			$file_type = 'single';
		}

		if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
			$file_type = 'post';
		}

		get_template_part( 'templates/loops/type/'. $file_type );
	
	}

	/**
	 * Function description
	 */
	public function pagination() {

		// if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
		// 	return null;
		// }
	
		bootstrap_pagination();
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function content_none() {
	
		get_template_part( 'templates/loops/type/none' );
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function comments_template() {

		if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		comments_template();
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function author_info() {

		if ( 'author' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		get_template_part( 'templates/parts/author', 'info' );
	
	}

	/**
	 * Function description
	 */
	public function archive_headline() {

		if ( ! in_array( CURRENT_TEMPLATE_SLUG, array( 'archive', 'author', 'search' ), true ) ) {
			return;
		}

		get_template_part( 'templates/parts/archive', 'headline' );
	}

	/**
	 * Append template for content header
	 */
	public function content_header() {
		/**
		 * Get the template for displaing the header's contents (header and nav tags)
		 */
		get_template_part( 'templates/parts/header', 'image' );
	}

	/**
	 * Append template for content header
	 * This is in test version.
	 */
	public function navbar_top() {

		if ( ! has_nav_menu( 'info-menu' ) || ! has_nav_menu( 'social-menu' ) ) {
			return;
		}
		/**
		 * Get the template for displaing the header's contents (header and nav tags)
		 */
		get_template_part( 'templates/parts/navbar', 'top' );
	}

	/**
	 * Do Footer
	 */
	public function do_footer( $value = '' ) {

		get_template_part( 'templates/parts/footer-widget-area' );
		get_template_part( 'templates/parts/footer-colophon' );

	}
}
