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
$layout = apply_filters( 'italystrap_layout_settings',
	[
		'content_sidebar'			=> \__( 'Content Sidebar', 'italystrap' ),
		// 'content_sidebar_sidebar'	=> \__( 'Content Sidebar Sidebar', 'italystrap' ),
		// 'sidebar_content_sidebar'	=> \__( 'Sidebar Content Sidebar', 'italystrap' ),
		// 'sidebar_sidebar_content'	=> \__( 'Sidebar Sidebar content', 'italystrap' ),
		'sidebar_content'			=> \__( 'Sidebar Content', 'italystrap' ),
		'full_width'				=> \__( 'Full width, no sidebar', 'italystrap' ),
	]
);

return $layout;
