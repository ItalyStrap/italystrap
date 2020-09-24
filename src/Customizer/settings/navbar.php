<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Media_Control;

/** @var \WP_Customize_Manager $manager */

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_navbar_options',
	[
		'title'			=> __( 'Navbar Settings', 'italystrap' ), // Visible title of section.
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize settings for the main navbar. Remember that this uses the Twitter Bootstrap Navbar style, if you want more info read the <a href="http://getbootstrap.com/components/#navbar" target="_blank">documentation</a>.', 'italystrap' ),
		'description_hidden'	=> true,
	]
);

/**
 * Select default or inverse navbar
 */
$manager->add_setting(
	'navbar[type]',
	[
		'default'			=> $this->theme_mods->get('navbar.type'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);
$manager->add_control(
	'italystrap_navbar[type]',
	array(
		'settings'	=> 'navbar[type]',
		'label'			=> __( 'Navbar type', 'italystrap' ),
		'description'	=> __( 'Select the type of navbar. By default is the <code>navbar-default</code> (light grey).', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'navbar-default'	=> __( 'Default navbar', 'italystrap' ),
			'navbar-inverse'	=> __( 'Inverse navbar', 'italystrap' ),
		),
	)
);

/**
 * Select the position of navbar
 */
$manager->add_setting(
	'navbar[position]',
	array(
		'default'			=> $this->theme_mods->get('navbar.position'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar[position]',
	array(
		'settings'	=> 'navbar[position]',
		'label'			=> __( 'Navbar position', 'italystrap' ),
		'description'	=> __( 'Select the position of the navbar. By default is set to <code>relative top</code>, you can chose <code>fixed top</code>, <code>fixed bottom</code> or <code>static top</code>, with the <code>static top</code> you also have to set the navbar <code>full width</code> for fixing the correct padding.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'navbar-relative-top'	=> __( 'Default relative top', 'italystrap' ),
			'navbar-static-top'		=> __( 'Static Top', 'italystrap' ),
			'navbar-fixed-top'		=> __( 'Fixed Top', 'italystrap' ),
			'navbar-fixed-bottom'	=> __( 'Fixed Bottom', 'italystrap' ),
		),
	)
);

/**
 * Select the nav_width of navbar
 */
$manager->add_setting(
	'navbar[nav_width]',
	array(
		'default'			=> $this->theme_mods->get('navbar.nav_width'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar[nav_width]',
	array(
		'settings'	=> 'navbar[nav_width]',
		'label'			=> __( 'Navbar width', 'italystrap' ),
		'description'	=> __( 'Select the nav_width of navbar, this enlarges the navbar to the windows size (use it also width Static Top option).', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'container'	=> __( 'Boxed', 'italystrap' ),
			'none'		=> __( 'Full width', 'italystrap' ),
		),
	)
);

/**
 * Select the menus_width of navbar
 */
$manager->add_setting(
	'navbar[menus_width]',
	array(
		'default'			=> $this->theme_mods->get('navbar.menus_width'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar[menus_width]',
	array(
		'settings'	=> 'navbar[menus_width]',
		'label'			=> __( '!!!!Navbar menus width', 'italystrap' ),
		'description'	=> __( 'Select the menus_width, this is the width of the container of the 2 menu, main-menu and secondary-menu, with the full width the menus will enlarge to the widnows size, with the "width of the content" they will sized like the size of the content. If you have select the "default boxed width" leave the default value.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'container-fluid'	=> __( 'Fluid', 'italystrap' ),
			'container'			=> __( 'Container', 'italystrap' ),
		),
	//		'active_callback'	=> function ( $control ) {
	//			return $control->manager->get_setting('navbar[nav_width]')->value() == 'none';
	//		},
	)
);
