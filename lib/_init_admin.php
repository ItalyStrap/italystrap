<?php
/**
 * This file init only admin functionality.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core;

if ( ! is_admin() ) {
	return;
}

$autoload_concrete = array_merge( $autoload_concrete, array(
	'ItalyStrap\Editors\TinyMCE',
	'ItalyStrap\Custom\Metabox\Register',
	'ItalyStrap\User\Contact_Methods',
) );

/**
 * TinyMCE Editor in Category description
 */
if ( 'edit-tags.php' === $pagenow || 'term.php' === $pagenow ) {
	$autoload_concrete[] = 'ItalyStrap\Editors\Category';
}

require( TEMPLATEPATH . '/functions/admin-functions.php' );

/**
 * Add fields to widget areas
 * The $register_metabox is declared in plugin
 */
if ( isset( $register_metabox ) ) {
	add_action( 'cmb2_admin_init', array( $register_metabox, 'register_widget_areas_fields' ) );
}
