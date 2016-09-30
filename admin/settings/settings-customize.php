<?php
/**
 * Settings for Customizer
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Admin;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Core as Core;

use WP_Customize_Manager;
use WP_Customize_Control;
use WP_Customize_Color_Control;
use	WP_Customize_Media_Control;
use	Textarea_Custom_Control;
use	ItalyStrapAdminMediaSettings;

/**
 * Changing Customizer Color Sections Titles
 */
$wp_customize->get_section( 'colors' )->title = __( 'Theme Colors', 'ItalyStrap' );

/**
 * 2. Register new settings to the WP database...
 */
$wp_customize->add_setting(
	'link_textcolor', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record.
	array(
		'default' => '#337ab7', // Default setting/value to save.
		'type' => 'theme_mod', // Is this an 'option' or a 'theme_mod'?
		'capability' => $this->capability, // Optional. Special permissions for accessing this setting.
		'transport' => 'postMessage', // What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		'sanitize_callback' => 'sanitize_hex_color',
		)
);

/**
 * 3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
 */
$wp_customize->add_control(
	new WP_Customize_Color_Control( // Instantiate the color control class
		$wp_customize, // Pass the $wp_customize object (required).
		'italystrap_link_textcolor', // Set a unique ID for the control.
		array(
			'label' => __( 'Link Color', 'ItalyStrap' ), // Admin-visible name of the control.
			'section' => 'colors', // ID of the section this control should render in (can be one of yours, or a WordPress default section).
			'settings' => 'link_textcolor', // Which setting to load and manipulate (serialized is okay).
			'priority' => 10, // Determines the order this control appears in for the specified section.
		)
	)
);

/**
 * Hx font color
 */
$wp_customize->add_setting(
	'hx_textcolor',
	array(
		'default' => '#333',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'italystrap_hx_textcolor',
		array(
			'label' => __( 'Heading Color', 'ItalyStrap' ),
			'section' => 'colors',
			'settings' => 'hx_textcolor',
			'priority' => 10,
		)
	)
);

/**
 * Add new panel for ItalyStrap theme options
 */
$wp_customize->add_panel( $this->panel,
	array(
		'title' => __( 'Theme Options', 'ItalyStrap' ),
		'description' => 'add_panel', // Include html tags such as <p>.
		'priority' => 160, // Mixed with top-level-section hierarchy.
	)
);

/**
 * Define a new section for theme image options
 */
$wp_customize->add_section(
	'italystrap_image_options',
	array(
		'title' => __( 'Theme Image Options', 'ItalyStrap' ), // Visible title of section.
		'panel' => $this->panel,
		'capability' => $this->capability,
		'description' => __( 'Allows you to customize settings for ItalyStrap.', 'ItalyStrap' ),
	)
);

/**
 * Register new settings to the WP database...
 */
$wp_customize->add_setting(
	'logo',
	array(
		'default' => TEMPLATEURL . '/img/italystrap-logo.jpg',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'italystrap_logo',
		array(
			'label' => __( 'Your Logo', 'ItalyStrap' ),
			'description' => __( 'Insert here your logo', 'ItalyStrap' ),
			'section' => 'italystrap_image_options',
			'settings' => 'logo',
			'priority' => 10,
		)
	)
);

/**
 * Setting for navbar logo image
 */
$wp_customize->add_setting(
	'navbar_logo_image',
	array(
		// 'default' => TEMPLATEURL . '/img/italystrap-navbar_logo_image.jpg',
		'default' => '',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'italystrap_navbar_logo_image',
		array(
			'label' => __( 'Your logo brand for nav menu', 'ItalyStrap' ),
			'description' => __( 'Insert here your logo brand for nav menu', 'ItalyStrap' ),
			'section' => 'italystrap_image_options',
			'settings' => 'navbar_logo_image',
			'priority' => 10,
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
$wp_customize->add_setting(
	'navbar_logo_image_size',
	array(
		'default' => 'navbar-brand-image',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'italystrap_navbar_logo_image_size',
	array(
		'settings'	=> 'navbar_logo_image_size',
		'label'		=> __( 'Logo image size', 'ItalyStrap' ),
		'section'	=> 'italystrap_image_options',
		'type'		=> 'select',
		'choices'	=> ( ( isset( $image_size_media_array ) ) ? $image_size_media_array : '' ),
	)
);

/**
 * Display navbar brand name with navbar logo image
 */
$wp_customize->add_setting(
	'display_navbar_logo_image',
	array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'italystrap_display_navbar_logo_image',
	array(
		'settings' => 'display_navbar_logo_image',
		'label'    => __( 'Display navbar brand name with navbar logo image', 'ItalyStrap' ),
		'section'  => 'italystrap_image_options',
		'type'     => 'checkbox',
	)
);

/**
 * Set a default image to use in:
 * the_thumbnail
 */
$wp_customize->add_setting(
	'default_image',
	array(
		'default' => TEMPLATEURL . '/img/italystrap-default-image.png',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'italystrap_default_image',
		array(
			'label' => __( 'Default Image', 'ItalyStrap' ),
			'description' => __( 'Upload an image for the default image used for social sharing (must be at least 1200x600px for Facebook), it will also be displayed if no feautured image will be added in your content page/post if the theme supports this feature.', 'ItalyStrap' ),
			'section' => 'italystrap_image_options',
			'settings' => 'default_image',
			'priority' => 10,
		)
	)
);

$wp_customize->add_setting(
	'default_404',
	array(
		'default' => TEMPLATEURL . '/img/404.jpg',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'italystrap_default_404',
		array(
			'label' => __( 'Default 404 Image', 'ItalyStrap' ),
			'description' => __( 'This is a default 404 image, it will be displayed in 404 page (must be at least weight 848px)', 'ItalyStrap' ),
			'section' => 'italystrap_image_options',
			'settings' => 'default_404',
			'priority' => 10,
		)
	)
);

/**
 * NEW SECTION
 */

/**
 * Define a new section for cusom CSS
 */
$wp_customize->add_section( 'custom_css',
	array(
		'title' => __( 'Custom CSS' ),
		'description' => __( 'Add custom CSS here' ),
		'panel' => $this->panel, // Not typically needed.
		'priority' => 160,
		'capability' => $this->capability,
		'theme_supports' => '', // Rarely needed.
	)
);

/**
 * Add a textarea control for custom css
 */
$wp_customize->add_setting(
	'custom_css',
	array(
		'default'        => '',
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Textarea_Custom_Control(
		$wp_customize,
		'custom_css',
		array(
			'label'   => __( 'Custom CSS', 'ItalyStrap' ),
			'description' => __( '', 'ItalyStrap' ),
			'section' => 'custom_css',
			'settings'   => 'custom_css',
			'priority' => 10,
		)
	)
);

/**
 * Define a new section for Footer colophon
 */
$wp_customize->add_section( 'colophon',
	array(
		'title' => __( 'Footer\'s Colophon' ),
		'description' => __( 'Add text for footer\'s colophon here' ),
		'panel' => $this->panel, // Not typically needed.
		'priority' => 160,
		'capability' => $this->capability,
		'theme_supports' => '', // Rarely needed.
	)
);

/**
 * Add a textarea control for Colophon
 */
$wp_customize->add_setting(
	'colophon',
	array(
		'default'        => $this->colophon_default_text,
		'type' => 'theme_mod',
		'capability' => $this->capability,
		'transport' => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);

$wp_customize->add_control(
	new Textarea_Custom_Control(
		$wp_customize,
		'colophon',
		array(
			'label'   => __( 'Footer\'s Colophon', 'ItalyStrap' ),
			'description' => __( '', 'ItalyStrap' ),
			'section' => 'colophon',
			'settings'   => 'colophon',
			'priority' => 10,
		)
	)
);

/**
 * Let's make some stuff use live preview JS...
 */
$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
