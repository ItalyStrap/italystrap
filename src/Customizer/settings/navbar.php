<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

use ItalyStrap\Config\ConfigInterface;
use WP_Customize_Media_Control;

/** @var ConfigInterface $mods */
$mods = $this->theme_mods;

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
		'default'			=> $mods->get('navbar.type'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);
$manager->add_control(
	'italystrap_navbar[type]',
	[
		'settings'	=> 'navbar[type]',
		'label'			=> __( 'Navbar color mode', 'italystrap' ),
		'description'	=> __( 'Select the color mode of the navbar.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> [
			'navbar-default'	=> __( 'Light mode', 'italystrap' ),
			'navbar-inverse'	=> __( 'Dark mode', 'italystrap' ),
		],
	]
);

/**
 * Select the position of navbar
 */
$manager->add_setting(
	'navbar[position]',
	array(
		'default'			=> $mods->get('navbar.position'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_navbar[position]',
	[
		'settings'	=> 'navbar[position]',
		'label'			=> __( 'Navbar vertical position', 'italystrap' ),
		'description'	=> __( 'Select the position of the navbar. By default is set to "relative top", you can chose "fixed top", "fixed bottom" or "static top", with the "static top" you also have to set the navbar "full width" for fixing the correct padding.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> [
			'navbar-relative-top'	=> __( 'Default relative top', 'italystrap' ),
			'navbar-static-top'		=> __( 'Static Top', 'italystrap' ),
			'navbar-fixed-top'		=> __( 'Fixed Top', 'italystrap' ),
			'navbar-fixed-bottom'	=> __( 'Fixed Bottom', 'italystrap' ),
		],
	]
);

/**
 * Select the nav_width of navbar
 */
$manager->add_setting(
	'navbar[nav_width]',
	array(
		'default'			=> $mods->get('navbar.nav_width'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar[nav_width]',
	[
		'settings'	=> 'navbar[nav_width]',
		'label'			=> __( 'Navbar width', 'italystrap' ),
		'description'	=> __( 'Select the nav_width of navbar, this enlarges the navbar to the windows size (use it also width Static Top option).', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> [
			'container'	=> __( 'Boxed', 'italystrap' ),
			'none'		=> __( 'Full width', 'italystrap' ),
		],
	]
);

/**
 * Select the menus_width of navbar
 */
$manager->add_setting(
	'navbar[menus_width]',
	array(
		'default'			=> $mods->get('navbar.menus_width'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar[menus_width]',
	[
		'settings'	=> 'navbar[menus_width]',
		'label'			=> __( 'Navbar menus width', 'italystrap' ),
		'description'	=> __( 'Select the menus_width, this is the width of the container of the 2 menu, main-menu and secondary-menu, with the full width the menus will enlarge to the widnows size, with the "width of the content" they will sized like the size of the content. If you have select the "default boxed width" leave the default value.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> [
			'container-fluid'	=> __( 'Expand', 'italystrap' ),
			'container'			=> __( 'Contained', 'italystrap' ),
		],
		//		'active_callback'	=> function ( $control ) {
		//			return $control->manager->get_setting('navbar[nav_width]')->value() == 'none';
		//		},
	]
);
