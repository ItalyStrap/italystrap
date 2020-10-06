<?php
declare(strict_types=1);
add_filter( 'italystrap_theme_updater', function ( array $edd_config ) {

	/**
	 * EDD configuration for this theme
	 *
	 * @link italystrap.com
	 * @since 4.0.0
	 *
	 * @package ItalyStrap
	 */

	//$item_name = ITALYSTRAP_THEME_NAME;
	$item_name = 'ItalyStrap Theme Framework';
	//$theme_slug = strtolower( $item_name );
	$theme_slug = 'italystrap';

	$edd_config[] = [
		'config'	=> [
			'item_name'      => $item_name, // Name of theme
			'theme_slug'     => $theme_slug, // Theme slug
			'version'        => ITALYSTRAP_THEME_VERSION, // The current version of this theme
			'author'         => wp_get_theme( \get_template() )->display( 'Author', false ), // The author of this theme
			'download_id'    => '', // Optional, used for generating a license renewal link
			'renew_url'      => '', // Optional, allows for a custom license renewal link
			'beta'           => get_theme_mod( 'beta', true ), // Optional, set to true to opt into beta versions
		],
		'strings'	=> [
			'theme-license'             => sprintf(
				/* translators: %s: Theme name */
				__( '%s License', 'italystrap' ),
				ITALYSTRAP_THEME_NAME
			),
		],
	];

	return $edd_config;
} );
