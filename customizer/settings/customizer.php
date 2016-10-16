<?php
/**
 * Settings for Customizer
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Customizer;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;

use ItalyStrap\Core as Core;
use	ItalyStrap\Customizer\Control\Textarea;

use	ItalyStrapAdminMediaSettings;

/**
 * Changing Customizer Color Sections Titles
 */
$manager->get_section( 'colors' )->title = __( 'Theme Colors', 'italystrap' );

/**
 * 2. Register new settings to the WP database...
 */
$manager->add_setting(
	'link_textcolor', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record.
	array(
		'default'			=> $this->theme_mods['link_textcolor'], // Default setting/value to save.
		'type'				=> 'theme_mod', // Is this an 'option' or a 'theme_mod'?
		'capability'		=> $this->capability, // Optional. Special permissions for accessing this setting.
		'transport'			=> 'postMessage', // What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		'sanitize_callback'	=> 'sanitize_hex_color',
		)
);

/**
 * 3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
 */
$manager->add_control(
	new WP_Customize_Color_Control( // Instantiate the color control class
		$manager, // Pass the $manager object (required).
		'italystrap_link_textcolor', // Set a unique ID for the control.
		array(
			'label'		=> __( 'Link Color', 'italystrap' ), // Admin-visible name of the control.
			'section'	=> 'colors', // ID of the section this control should render in (can be one of yours, or a WordPress default section).
			'settings'	=> 'link_textcolor', // Which setting to load and manipulate (serialized is okay).
			'priority'	=> 10, // Determines the order this control appears in for the specified section.
		)
	)
);

/**
 * Hx font color
 */
$manager->add_setting(
	'hx_textcolor',
	array(
		'default'			=> $this->theme_mods['hx_textcolor'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_hex_color',
	)
);

$manager->add_control(
	new WP_Customize_Color_Control(
		$manager,
		'italystrap_hx_textcolor',
		array(
			'label'		=> __( 'Heading Color', 'italystrap' ),
			'section'	=> 'colors',
			'settings'	=> 'hx_textcolor',
			'priority'	=> 10,
		)
	)
);

/**
 * Add new panel for ItalyStrap theme options
 */
$manager->add_panel( $this->panel,
	array(
		'title'			=> __( 'Theme Options', 'italystrap' ),
		'description'	=> 'add_panel', // Include html tags such as <p>.
		'priority'		=> 160, // Mixed with top-level-section hierarchy.
	)
);

/**
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_image_options',
	array(
		'title'			=> __( 'Theme Image Options', 'italystrap' ), // Visible title of section.
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize settings for ItalyStrap.', 'italystrap' ),
	)
);

/**
 * Register new settings to the WP database...
 */
$manager->add_setting(
	'logo',
	array(
		'default'			=> $this->theme_mods['logo'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_logo',
		array(
			'label'			=> __( 'Your Logo', 'italystrap' ),
			'description'	=> __( 'Insert here your logo', 'italystrap' ),
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'logo',
			'priority'		=> 10,
		)
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
		'transport'			=> 'postMessage',
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
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'navbar_logo_image',
			'priority'		=> 10,
		)
	)
);

		/**
		 * Instance of list of image sizes
		 * @var ItalyStrapAdminMediaSettings
		 */
		$image_size_media = new ItalyStrapAdminMediaSettings;
		$image_size_media_array = $image_size_media->get_image_sizes( array( 'full' => __( 'Real size', 'italystrap' ) ) );

/**
 * Display navbar logo image size list
 */
$manager->add_setting(
	'navbar_logo_image_size',
	array(
		'default'			=> $this->theme_mods['navbar_logo_image_size'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_navbar_logo_image_size',
	array(
		'settings'	=> 'navbar_logo_image_size',
		'label'		=> __( 'Logo image size', 'italystrap' ),
		'section'	=> 'italystrap_image_options',
		'type'		=> 'select',
		'choices'	=> ( ( isset( $image_size_media_array ) ) ? $image_size_media_array : '' ),
	)
);

/**
 * Display navbar brand name with navbar logo image
 */
$manager->add_setting(
	'display_navbar_brand-test[test1]',
	array(
		// 'default'			=> $this->theme_mods['display_navbar_brand-test'],
		// 'default'			=> ,
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_display_navbar_brand-test',
	array(
		'settings' => 'display_navbar_brand-test[test1]',
		'label'    => __( 'Display the navbar brand test', 'italystrap' ),
		'section'  => 'italystrap_image_options',
		'type'     => 'checkbox',
	)
);

/**
 * Display navbar brand name with navbar logo image
 */
$manager->add_setting(
	'display_navbar_brand',
	array(
		'default'			=> $this->theme_mods['display_navbar_brand'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_display_navbar_brand',
	array(
		'settings' => 'display_navbar_brand',
		'label'    => __( 'Display the navbar brand', 'italystrap' ),
		'section'  => 'italystrap_image_options',
		'type'     => 'checkbox',
	)
);

/**
 * Display navbar brand name with navbar logo image
 */
$manager->add_setting(
	'display_navbar_logo_image',
	array(
		'default'			=> $this->theme_mods['display_navbar_logo_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);
$manager->add_control(
	'italystrap_display_navbar_logo_image',
	array(
		'settings' => 'display_navbar_logo_image',
		'label'    => __( 'Display navbar brand name with navbar logo image', 'italystrap' ),
		'section'  => 'italystrap_image_options',
		'type'     => 'checkbox',
	)
);

/**
 * Set a default image to use in:
 * the_thumbnail
 */
$manager->add_setting(
	'default_image',
	array(
		'default'			=> $this->theme_mods['default_image'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_default_image',
		array(
			'label'			=> __( 'Default Image', 'italystrap' ),
			'description'	=> __( 'Upload an image for the default image used for social sharing (must be at least 1200x600px for Facebook), it will also be displayed if no feautured image will be added in your content page/post if the theme supports this feature.', 'italystrap' ),
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'default_image',
			'priority'		=> 10,
		)
	)
);

$manager->add_setting(
	'default_404',
	array(
		'default'			=> $this->theme_mods['default_404'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_default_404',
		array(
			'label'			=> __( 'Default 404 Image', 'italystrap' ),
			'description'	=> __( 'This is a default 404 image, it will be displayed in 404 page (must be at least weight 848px)', 'italystrap' ),
			'section'		=> 'italystrap_image_options',
			'settings'		=> 'default_404',
			'priority'		=> 10,
		)
	)
);

/**
 * NEW SECTION
 */

/**
 * Define a new section for cusom CSS
 */
$manager->add_section(
	'custom_css',
	array(
		'title'				=> __( 'Custom CSS' ),
		'description'		=> __( 'Add custom CSS here' ),
		'panel'				=> $this->panel, // Not typically needed.
		'priority'			=> 160,
		'capability'		=> $this->capability,
		'theme_supports'	=> '', // Rarely needed.
	)
);

/**
 * Add a textarea control for custom css
 */
$manager->add_setting(
	'custom_css',
	array(
		'default'			=> $this->theme_mods['custom_css'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	new Textarea(
		$manager,
		'custom_css',
		array(
			'label'			=> __( 'Custom CSS', 'italystrap' ),
			'description'	=> __( '', 'italystrap' ),
			'section'		=> 'custom_css',
			'settings'		=> 'custom_css',
			'priority'		=> 10,
		)
	)
);

/**
 * Define a new section for Footer colophon
 */
$manager->add_section(
	'colophon',
	array(
		'title'				=> __( 'Footer\'s Colophon' ),
		'description'		=> __( 'Add text for footer\'s colophon here' ),
		'panel'				=> $this->panel, // Not typically needed.
		'priority'			=> 160,
		'capability'		=> $this->capability,
		'theme_supports'	=> '', // Rarely needed.
	)
);

/**
 * Add a textarea control for Colophon
 */
$manager->add_setting(
	'colophon',
	array(
		'default'			=> $this->theme_mods['colophon'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'wp_kses_post',
	)
);

$manager->add_control(
	new Textarea(
		$manager,
		'colophon',
		array(
			'label'			=> __( 'Footer\'s Colophon', 'italystrap' ),
			'description'	=> __( '', 'italystrap' ),
			'section'		=> 'colophon',
			'settings'		=> 'colophon',
			'priority'		=> 10,
		)
	)
);

/**
 * Let's make some stuff use live preview JS...
 */
$manager->get_setting( 'blogname' )->transport = 'postMessage';
$manager->get_setting( 'blogdescription' )->transport = 'postMessage';
$manager->get_setting( 'header_textcolor' )->transport = 'postMessage';
$manager->get_setting( 'background_color' )->transport = 'postMessage';
