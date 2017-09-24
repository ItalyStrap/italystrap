<?php
/**
 * View Interface
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap\View
 */


namespace ItalyStrap\Views;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface View_Interface {

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
	public function get( $slug, $name = null, $load = false );

	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH and wp-includes/theme-compat
	 * so that themes which inherit from a parent theme can just overload one file.
	 *
	 * @since 2.7.0
	 *
	 * @param string|array $template_names Template file(s) to search for, in order.
	 * @param bool         $load           If true the template file will be loaded if it is found.
	 * @param bool         $require_once   Whether to require_once or require. Default true. Has no effect if $load is false.
	 *
	 * @return string The template filename if one is located.
	 */
	public function has( $template_names, $load = false, $require_once = true );
}
