<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Media_Control;

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
	array(
		'default'			=> $this->theme_mods['navbar']['type'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
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
		'default'			=> $this->theme_mods['navbar']['position'],
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
		'default'			=> $this->theme_mods['navbar']['nav_width'],
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
		'default'			=> $this->theme_mods['navbar']['menus_width'],
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

/**
 * Display navbar brand name with navbar logo image
 */
$manager->add_setting(
	// 'display_navbar_brand[test1]',
	'display_navbar_brand',
	array(
		'default'			=> $this->theme_mods['display_navbar_brand'],
		// 'default'			=> 'display_name',
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
	//		'transport'			=> 'refresh',
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'display_navbar_brand',
	array(
		// 'settings'	=> 'display_navbar_brand[test1]',
		'settings'		=> 'display_navbar_brand',
		'label'			=> __( 'Display the navbar brand', 'italystrap' ),
		'description'	=> __( 'Select the type of navbar brand to visualize or select to hide navbar brand, if you select to visualize navbar with image you also have to select the image and the size of the image to visualize in the above controls.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'none'			=> __( 'Hide navbar brand', 'italystrap' ),
			'display_image'	=> __( 'Display navbar brand image', 'italystrap' ),
			'display_name'	=> __( 'Display navbar brand name', 'italystrap' ),
			'display_all'	=> __( 'Display navbar brand image and name', 'italystrap' ),
		),
	)
);

/**
 * Setting for navbar logo image
 */
$manager->add_setting(
	'navbar_logo_image',
	array(
		'default'			=> $this->theme_mods['navbar_logo_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_navbar_logo_image',
		array(
			'label'			=> __( 'Your logo brand for nav menu', 'italystrap' ),
			'description'	=> __( 'Insert here your logo brand for nav menu', 'italystrap' ),
			'section'		=> 'italystrap_navbar_options',
			'settings'		=> 'navbar_logo_image',
			'priority'		=> 10,
		)
	)
);

/**
 * Display navbar logo image size list
 */
$manager->add_setting(
	'navbar_logo_image_size',
	array(
		'default'			=> $this->theme_mods['navbar_logo_image_size'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar_logo_image_size',
	array(
		'settings'	=> 'navbar_logo_image_size',
		'label'		=> __( 'Logo image size', 'italystrap' ),
		'section'	=> 'italystrap_navbar_options',
		'type'		=> 'select',
		'choices'	=> apply_filters( 'image_size_names_choose', [] ),
	)
);



/**
 * Setting for navbar logo image for mobile
 */
$manager->add_setting(
	'navbar_logo_image_mobile',
	array(
		'default'			=> $this->theme_mods->get('navbar_logo_image_mobile'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_navbar_logo_image_mobile',
		array(
			'label'			=> __( 'Logo for mobile', 'italystrap' ),
			'description'	=> __( 'Insert here the logo for the mobile version of your site. You also have to make shure that the theme support it otherwise you have to add the CSS for visualiza the logo only on mobile.', 'italystrap' ),
			'section'		=> 'italystrap_navbar_options',
			'settings'		=> 'navbar_logo_image_mobile',
			'priority'		=> 10,
		)
	)
);
