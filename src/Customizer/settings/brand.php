<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use WP_Customize_Manager;
use WP_Customize_Media_Control;

/** @var ConfigInterface $mods */
$mods = $this->theme_mods;

$section_id = 'title_tagline';

/**
 * @var WP_Customize_Manager $manager
 */
$manager->add_setting(
	'separator',
	[
//		'sanitize_callback' => 'sanitize_text_field',
	]
);

$manager->add_control(
	new class(
		$manager,
		'italystrap_separator',
		[
			'capability'	=> $this->capability,
			'section'		=> $section_id,
			'settings'		=> 'separator',
			'priority'		=> 80,
		]
	) extends \WP_Customize_Control {

		protected function render_content() {
			?>
			<style>
				.ciao {
				}
			</style>

			<?php
			echo '<label><br><hr class="ciao"><br></label>';
		}
	}
);

$manager->add_setting(
	'logo',
	[
		'default'			=> $mods->get('logo'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_logo',
		[
			'label'			=> __( 'Your brand logo {deprecated}', 'italystrap' ),
			'description'	=> __( 'Insert here your logo', 'italystrap' ),
			'section'		=> $section_id,
			'settings'		=> 'logo',
			'priority'		=> 80,
		]
	)
);

/**
 * Display navbar brand name with navbar logo image
 */
$manager->add_setting(
// 'display_navbar_brand[test1]',
	'display_navbar_brand',
	[
		'default'			=> $this->theme_mods->get('display_navbar_brand'),
		// 'default'			=> 'display_name',
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		//		'transport'			=> 'refresh',
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);
$manager->add_control(
	'display_navbar_brand',
	[
		// 'settings'	=> 'display_navbar_brand[test1]',
		'settings'		=> 'display_navbar_brand',
		'label'			=> __( 'Display the navbar brand', 'italystrap' ),
		'description'	=> __( 'Select the type of navbar brand to visualize or select to hide navbar brand, if you select to visualize navbar with image you also have to select the image and the size of the image to visualize in the above controls.', 'italystrap' ),
		'section'		=> $section_id,
		'type'			=> 'radio',
		'priority'		=> 80,
		'choices'		=> [
			'none'			=> __( 'Hide navbar brand', 'italystrap' ),
			'display_image'	=> __( 'Display navbar brand image', 'italystrap' ),
			'display_name'	=> __( 'Display navbar brand name', 'italystrap' ),
			'display_all'	=> __( 'Display navbar brand image and name', 'italystrap' ),
		],
	]
);

/**
 * Setting for navbar logo image
 */
$manager->add_setting(
	'navbar_logo_image',
	[
		'default'			=> $this->theme_mods->get('navbar_logo_image'),
		'type'				=> 'theme_mod',
		'capability'		=> $this->capability,
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'sanitize_text_field',
	]
);

$manager->add_control(
	new WP_Customize_Media_Control(
		$manager,
		'italystrap_navbar_logo_image',
		[
			'label'			=> __( 'Your logo brand for nav menu', 'italystrap' ),
			'description'	=> __( 'Insert here your logo brand for nav menu', 'italystrap' ),
			'section'		=> $section_id,
			'settings'		=> 'navbar_logo_image',
			'priority'		=> 80,
		]
	)
);

/**
 * Display navbar logo image size list
 */
$manager->add_setting(
	'navbar_logo_image_size',
	array(
		'default'			=> $this->theme_mods->get('navbar_logo_image_size'),
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
		'section'	=> $section_id,
		'type'		=> 'select',
		'priority'		=> 80,
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
			'section'		=> $section_id,
			'settings'		=> 'navbar_logo_image_mobile',
			'priority'		=> 80,
		)
	)
);
