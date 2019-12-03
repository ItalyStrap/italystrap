<?php
/**
 * This file init only admin functionality.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap;

if ( ! \is_admin() ) {
	return [];
}

$subscribers = [
	Admin\Editors\TinyMCE::class,
];

/**
 * Add fields to widget areas
 * The $register_metabox is declared in plugin
 */
if ( isset( $register_metabox ) ) {
	\add_action( 'cmb2_admin_init', array( $register_metabox, 'register_widget_areas_fields' ) );
}

return $subscribers;
