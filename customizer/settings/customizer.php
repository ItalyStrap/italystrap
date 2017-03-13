<?php
/**
 * Settings for Customizer
 *
 * @link https://github.com/WPTRT/code-examples
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
 * Container Width of the header
 */
$manager->add_setting(
	'custom_header[container_width]',
	array(
		'default'			=> $this->theme_mods['custom_header']['container_width'],
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	)
);

$manager->add_control(
	'italystrap_custom_header[container_width]',
	array(
		'label'		=> __( 'Container Width of the header', 'italystrap' ),
		'section'	=> 'header_image',
		'type'		=> 'select',
		'settings'	=> 'custom_header[container_width]',
		'choices'	=> array(
			// 'none'				=> __( 'None', 'italystrap' ),
			'container-fluid'	=> __( 'Full witdh', 'italystrap' ),
			'container'			=> __( 'Standard width', 'italystrap' ),
		),
	)
);

/**
 * Select the nav_width of navbar
 */
// $manager->add_setting(
// 	'navbar[nav_width]',
// 	array(
// 		'default'			=> $this->theme_mods['navbar']['nav_width'],
// 		'type'				=> 'theme_mod',
// 		'capability'		=> $this->capability,
// 		'transport'			=> 'postMessage',
// 		'sanitize_callback'	=> 'sanitize_text_field',
// 	)
// );
// $manager->add_control(
// 	'italystrap_navbar[nav_width]',
// 	array(
// 		'settings'	=> 'navbar[nav_width]',
// 		'label'			=> __( 'Navbar width', 'italystrap' ),
// 		'description'	=> __( 'Select the nav_width of navbar, this enlarges the navbar to the windows size (use it also width Static Top option).', 'italystrap' ),
// 		'section'		=> 'italystrap_navbar_options',
// 		'type'			=> 'radio',
// 		'choices'		=> array(
// 			'container'	=> __( 'Default boxed width', 'italystrap' ),
// 			'none'		=> __( 'Full width', 'italystrap' ),
// 		),
// 	)
// );

/**
 * Add new panel for ItalyStrap theme options
 */
$manager->add_panel( $this->panel,
	array(
		'title'			=> __( 'Theme Options', 'italystrap' ),
		'description'	=> 'add_panel', // Include html tags such as <p>.
		// 'priority'		=> 160, // Mixed with top-level-section hierarchy.
		'priority'		=> 10, // Mixed with top-level-section hierarchy.
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
 * Define a new section for theme image options
 */
$manager->add_section(
	'italystrap_navbar_options',
	array(
		'title'			=> __( 'Navbar Settings', 'italystrap' ), // Visible title of section.
		'panel'			=> $this->panel,
		'capability'	=> $this->capability,
		'description'	=> __( 'Allows you to customize settings for the main navbar. Remember that this uses the Twitter Bootstrap Navbar style, if you want more info read the <a href="http://getbootstrap.com/components/#navbar" target="_blank">documentation</a>.', 'italystrap' ),
	)
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
			'navbar-fixed-top'		=> __( 'Fixed Top', 'italystrap' ),
			'navbar-fixed-bottom'	=> __( 'Fixed Bottom', 'italystrap' ),
			'navbar-static-top'		=> __( 'Static Top', 'italystrap' ),
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
			'container'	=> __( 'Default boxed width', 'italystrap' ),
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
		'label'			=> __( 'Navbar menus width', 'italystrap' ),
		'description'	=> __( 'Select the menus_width, this is the width of the container of the 2 menu, main-menu and secondary-menu, with the full width the menus will enlarge to the widnows size, with the "width of the content" they will sized like the size of the content. If you have select the "default boxed width" leave the default value.', 'italystrap' ),
		'section'		=> 'italystrap_navbar_options',
		'type'			=> 'radio',
		'choices'		=> array(
			'container-fluid'	=> __( 'The width of navbar wrapper', 'italystrap' ),
			'container'			=> __( 'The width of the content', 'italystrap' ),
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
		'choices'	=> ( ( isset( $image_size_media_array ) ) ? $image_size_media_array : '' ),
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
		'transport'			=> 'refresh',
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
 * Define a new section for cusom CSS
 */
$manager->add_section(
	'custom_css',
	array(
		'title'				=> __( 'Additional CSS' ),
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
		'transport'			=> 'refresh',
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
