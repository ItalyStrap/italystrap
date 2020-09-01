<?php
/**
 * Theme configuration file.
 *
 * This is the configuration settings of the theme, you can override the value by filters.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

$site_width = \apply_filters(
	'italystrap_theme_width_settings',
	[
//		'none'				=> \__( 'None', 'italystrap' ),
		'container'			=> \__( 'Standard container', 'italystrap' ),
		'container-fluid'	=> \__( 'Fluid container', 'italystrap' ),
	]
);

return $site_width;
