<?php
/**
 * Customizer API for WordPress
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 3.0.0
 *
 * @package ItalyStrap\Customizer
 */

namespace ItalyStrap\Customizer;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Core as Core;

use WP_Customize_Manager;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * https://paulund.co.uk/custom-wordpress-controls
 *
 * @todo https://codex.wordpress.org/Function_Reference/header_textcolor
 * @todo https://github.com/overclokk/wordpress-theme-customizer-custom-controls
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/
 * @since ItalyStrap 1.0
 */
class Customizer {

	/**
	 * $capability
	 *
	 * @var string
	 */
	private $capability = 'edit_theme_options';

	/**
	 * Variable with all CSS
	 *
	 * @var string
	 */
	private $style = '';

	/**
	 * ItalyStrap option panel page name
	 *
	 * @var string
	 */
	private $panel = 'italystrap_options_page';
	// private $panel = null;

	/**
	 * Theme mods settings
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * Init the class
	 */
	function __construct( array $theme_mods = array() ) {

		$this->theme_mods = $theme_mods;
	}

	/**
	 * Register the customizer settings
	 *
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see add_action( 'customize_register', $func )
	 * @see https://developer.wordpress.org/reference/hooks/customize_register/
	 *
	 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since ItalyStrap 1.0
	 *
	 * @param  WP_Customize_Manager $manager WP_Customize_Manager object.
	 *
	 * @return WP_Customize_Manager          Return the manager object
	 */
	public function register_init( WP_Customize_Manager $manager ) {

		$this->config = (array) require(  TEMPLATEPATH . '/config/customizer.php'  );

		// $this->register( $manager );

		require(  TEMPLATEPATH . '/customizer/settings/customizer.php'  );

		// Hide core sections/controls when they aren't used on the current page.
		// $manager->get_section( 'header_image' )->active_callback = 'is_front_page';
		// $manager->get_control( 'blogdescription' )->active_callback = 'is_front_page';

		do_action( 'italystrap_after_customize_register', $manager, $this );

		// return $manager;

	}

	/**
	 * Register
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function register( WP_Customize_Manager $manager ) {

		foreach ( $this->config as $panel_id => $args ) {

			if ( 'panel' === $args['type'] ) {
				$manager->add_panel( $panel_id, $args['args'] );
			}

			foreach ( $args['sections'] as $section_id => $section ) {

				if ( 'panel' === $args['type'] ) {
					$section['args']['panel'] = $panel_id;
				}

				$manager->add_section( $section_id, $section['args'] );

				foreach ( $section['config'] as $config_id => $config_val ) {

					$manager->add_setting(
						$config_id,
						$this->get_setting_default( $config_val['setting'] )
					);

					// $class_name = 'WP_Customize_Media_Control';

					// d( new $class_name( $manager, 'id', array() ) );

					$manager->add_control( $config_val['control'] );
				}
			}
		}
	}

	/**
	 * Get setting default
	 *
	 * @param  array $setting The setting array.
	 *
	 * @return array          The setting array with default.
	 */
	public function get_setting_default( array $setting = array() ) {

		$defaults = array(
			'default'			=> null,
			'type'				=> 'theme_mod',
			'capability'		=> $this->capability,
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',
		);

		return wp_parse_args( $setting, $defaults );
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function FunctionName( WP_Customize_Manager $manager ) {
	
		$manager->add_section(
			$id, // A unique slug-like string to use as an id. 
			$args // An associative array containing arguments for the control. 
				  // array(
				  // 	'title'				=> '',
				  // 	'priority'			=> '',
				  // 	'description'		=> '',
				  // 	'active_callback'	=> '',
				  // )
		);
		$manager->add_settings(
			$id, // A unique slug-like ID for the theme setting.
			$args // An associative array containing arguments for the setting. 
				  // array(
				  // 	'default'				=> '',
				  // 	'type'					=> '',
				  // 	'capability'			=> '',
				  // 	'theme_supports'		=> '',
				  // 	'transport'				=> '',
				  // 	'sanitize_callback'		=> '',
				  // 	'sanitize_js_callback'	=> '',
				  // )
		);
		$manager->add_control(
			$id,
			$args // or WP_Customize_Control object
		);
	
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 * are using 'transport'=>'postMessage' instead of the default 'transport'
	 * => 'refresh'
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action( 'customize_preview_init', $func )
	 * @since ItalyStrap 1.0
	 */
	public function live_preview() {

		wp_enqueue_script(
			'italystrap-theme-customizer',
			TEMPLATEURL . '/customizer/js/src/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);

	}
}
