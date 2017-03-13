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

require( TEMPLATEPATH . '/admin/functions.php' );

/**
 * Add link to Theme Options in case ItalyStrap plugin is active
 */
if ( defined( 'ITALYSTRAP_PLUGIN' ) ) {
	/**
	 * Add new voice to theme menu
	 */
	add_action( 'admin_menu', array( $init, 'add_appearance_menu' ) );
	add_action( 'admin_menu', array( $init, 'add_link_to_theme_option_page' ) );
}

/**
 * Admin functionality
 */
$admin_text_editor = $injector->make( '\ItalyStrap\Admin\Tinymce\Editor' );
add_filter( 'mce_buttons_2', array( $admin_text_editor, 'reveal_hidden_tinymce_buttons' ) );
/**
 * Add Next Page Button in First Row
 */
add_filter( 'mce_buttons', array( $admin_text_editor, 'break_page_button' ), 1, 2 );
/**
 * @see ItalyStrap\Admin\Tinymce\Editor::add_new_format_to_mce()
 */
add_filter( 'tiny_mce_before_init', array( $admin_text_editor, 'add_new_format_to_mce' ), 9999, 2 );

/**
 * TinyMCE Editor in Category description
 */
$editor = $injector->make( '\ItalyStrap\Admin\Category\Editor' );

/**
 * Add fields to widget areas
 * The $register_metabox is declared in plugin
 */
if ( isset( $register_metabox ) ) {
	add_action( 'cmb2_admin_init', array( $register_metabox, 'register_widget_areas_fields' ) );
}

/**
 * Register the metabox
 *
 * @var Register_Meta
 */
$metabox = $injector->make( '\ItalyStrap\Admin\Metabox\Register' );
add_action( 'cmb2_admin_init', array( $metabox, 'register_metaboxes' ) );

$contactmethods = $injector->make( '\ItalyStrap\Core\User\Contact_Methods' );
add_filter( 'user_contactmethods', array( $contactmethods, 'run' ), 10, 1 );
