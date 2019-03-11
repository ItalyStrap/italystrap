<?php

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Render the HTML tag attributes from an array
 *
 * @param  array $attr The HTML attributes with key value.
 * @return string      Return a string with HTML attributes
 */
function get_html_tag_attr( array $attr = array(), $context = '' ) {

	_deprecated_function( __FUNCTION__, '4.0.0', 'ItalyStrap\Core\get_attr()' );

	// $html = '';

	// $attr = array_map( 'esc_attr', $attr );
	// foreach ( $attr as $name => $value ) {
	// 	$html .= " $name=" . '"' . $value . '"';
	// }

	return get_attr( $context, $attr, false, null );
}


/**
 * Fallback function for custom background.
 */
function _custom_background_cb() {

	_deprecated_function( __FUNCTION__, '4.0.0', 'ItalyStrap\Core\Css\Css::custom_background_cb()' );

	global $italystrap_customizer;

	if ( ! $italystrap_customizer ) {
		$italystrap_customizer = new \ItalyStrap\Customizer\Customizer;
	}

	$italystrap_customizer->custom_background_cb();

}



/**
 * Display the breadcrumbs
 *
 * THIS FUNCTION IS NO MORE NEEDED
 *
 * @param array $defaults Default array for parameters.
 */
function display_breadcrumbs( $defaults = array() ) {

	_deprecated_function( __FUNCTION__, '4.0.0', 'The breadcrumbs are now autoloaded from the controller' );

	$template_settings = (array) \ItalyStrap\Factory\get_config()->get('post_content_template');

	if ( in_array( 'hide_breadcrumbs', $template_settings, true ) ) {
		return;
	}

	$args = array(
		'home'	=> '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>',
	);

	do_action( 'do_breadcrumbs', $args );
}
