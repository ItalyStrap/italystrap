<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_breadcrumbs_show_on',
	array(
		'title'			=> __( 'Breadcrumbs', 'italystrap' ),
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to show the breadcrumbs on selected templates.', 'italystrap' ),
	)
);

if ( ! class_exists( '\ItalyStrap\Customizer\Control\Multicheck' ) ) {
	return;
}

/**
 * Container Width of the header
 */
$manager->add_setting(
	'breadcrumbs_show_on',
	array(
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

/**
 * https://paulund.co.uk/get-theme-page-templates
 *
 * @var \WP_Theme
 */
$theme = wp_get_theme();
$page_templates = $theme->get_page_templates();

$templates = array(
	'404.php'			=> __( '404', 'italystrap' ),
	'archive.php'		=> __( 'Archive', 'italystrap' ),
	'author.php'		=> __( 'Author', 'italystrap' ),
	'front-page.php'	=> __( 'Front page', 'italystrap' ),
	'home.php'			=> __( 'Home', 'italystrap' ),
	'page.php'			=> __( 'Page', 'italystrap' ),
	'search.php'		=> __( 'Search', 'italystrap' ),
	'single.php'		=> __( 'Single', 'italystrap' ),
);

$manager->add_control(
	new Multicheck(
		$manager,
		'italystrap_breadcrumbs_show_on',
		array(
			'label'		=> __( 'Display breadcrumbs on', 'italystrap' ),
			'section'	=> 'italystrap_breadcrumbs_show_on',
			'type'		=> 'multicheck',
			'settings'	=> 'breadcrumbs_show_on',
			'choices'	=> array_merge( $templates, $page_templates ),
		)
	)
);
