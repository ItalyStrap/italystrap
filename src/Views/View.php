<?php
/**
 * View API: View Class
 *
 * @package ItalyStrap\Views
 *
 * @since 4.0.0
 */

namespace ItalyStrap\Views;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Template Class
 */
class View implements View_Interface {

	/**
	 * Init the class
	 *
	 * @param array $theme_mod Class configuration array.
	 */
	public function __construct() {}

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
	public function get( $slug, $name = null, $load = false ) {
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
