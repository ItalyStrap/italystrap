<?php
declare(strict_types=1);

/**
 * Customizer API for ItalyStrap Theme Framework
 *
 * @link https://italystrap.com
 * @since 3.0.0
 *
 * @package ItalyStrap\Customizer
 */

namespace ItalyStrap\Customizer;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Image\Size;
use WP_Customize_Manager;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * https://paulund.co.uk/custom-wordpress-controls
 *
 * @since ItalyStrap 1.0
 *
 */
class CustomizerBeta implements SubscriberInterface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked customize_register - 99
	 * @hooked customize_preview_init - 10
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return array(
			// 'hook_name'							=> 'method_name',
			'customize_register'		=> array(
				'function_to_add'		=> 'customizeRegister',
				'priority'				=> 99,
			),
			'customize_preview_init'	=> 'livePreview',
			'admin_menu'				=> 'addLinkToThemeOptionPage',
		);
	}

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

	/**
	 * Theme mods settings
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * Instance of Size Class
	 *
	 * @var Size
	 */
	private $size;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * Init the class
	 * @param array $theme_mods
	 * @param Size $size
	 */
	public function __construct( array $theme_mods = array(), Size $size = null ) {
		$this->theme_mods = $theme_mods;
		$this->size = $size;
	}

	/**
	 * Register the customizer settings
	 *
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See livePreview() for more.
	 *
	 * @see add_action( 'customize_register', $func )
	 * @see https://developer.wordpress.org/reference/hooks/customize_register
	 * @link https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/
	 *
	 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since ItalyStrap 1.0
	 *
	 * @todo https://codex.wordpress.org/Function_Reference/header_textcolor
	 * @todo https://github.com/overclokk/wordpress-theme-customizer-custom-controls
	 *
	 * @link http://codex.wordpress.org/Theme_Customization_API
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/
	 *
	 * @param  WP_Customize_Manager $manager WP_Customize_Manager object.
	 */
	public function customizeRegister( WP_Customize_Manager $manager ) {

		$transport = $manager->selective_refresh ? 'postMessage' : 'refresh';

		$this->config = (array) require PARENTPATH . '/config/customizer.php';

		// $this->register( $manager );

		$files = array(
			'/settings/customizer.php',
			'/settings/custom-css.php',
			'/settings/layout.php',
			'/settings/header.php',
			'/settings/colors.php',
			'/settings/navbar.php',
			'/settings/breadcrumbs.php',
			'/settings/images.php',
			'/settings/post-content-template.php',
			'/settings/404.php',
			'/settings/colophon.php',
			'/settings/beta.php',
		);

		foreach ( $files as $file ) {
			require __DIR__ . $file;
		}

		// Hide core sections/controls when they aren't used on the current page.
		// $manager->get_section( 'header_image' )->active_callback = 'is_front_page';
		// $manager->get_control( 'blogdescription' )->active_callback = 'is_front_page';

		do_action( 'italystrap_after_customize_register', $manager, $this );
	}

	/**
	 * @param WP_Customize_Manager $manager
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
						$this->getSettingDefault( $config_val['setting'] )
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
	public function getSettingDefault( array $setting = array() ) {

		$defaults = array(
			'default'			=> null,
			'type'				=> 'theme_mod',
			'capability'		=> $this->capability,
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'sanitize_text_field',
		);

		return array_merge( $defaults, $setting );
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
//	public function FunctionName( WP_Customize_Manager $manager ) {
//
//		$manager->add_section(
//			$id, // A unique slug-like string to use as an id.
//			$args // An associative array containing arguments for the control.
//				  // array(
//				  // 	'title'				=> '',
//				  // 	'priority'			=> '',
//				  // 	'description'		=> '',
//				  // 	'active_callback'	=> '',
//				  // )
//		);
//		$manager->add_settings(
//			$id, // A unique slug-like ID for the theme setting.
//			$args // An associative array containing arguments for the setting.
//				  // array(
//				  // 	'default'				=> '',
//				  // 	'type'					=> '',
//				  // 	'capability'			=> '',
//				  // 	'theme_supports'		=> '',
//				  // 	'transport'				=> '',
//				  // 	'sanitize_callback'		=> '',
//				  // 	'sanitize_js_callback'	=> '',
//				  // )
//		);
//		$manager->add_control(
//			$id,
//			$args // or WP_Customize_Control object
//		);
//
//	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 * are using 'transport'=>'postMessage' instead of the default 'transport'
	 * => 'refresh'
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action( 'customize_preview_init', $func )
	 *
	 * @since ItalyStrap 1.0
	 *
	 */
	public function livePreview() {

		wp_enqueue_script(
			'italystrap-theme-customizer',
			TEMPLATEURL . '/src/Customizer/js/src/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);
	}

	/**
	 * Function for adding link to Theme Options in case ItalyStrap plugin is active
	 *
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#focusing
	 * autofocus[panel|section|control]=ID
	 */
	public function addLinkToThemeOptionPage() {

		add_submenu_page(
			'italystrap-dashboard',
			__( 'Theme Options', 'italystrap' ),
			__( 'Theme Options', 'italystrap' ),
			$this->capability,
			admin_url( 'customize.php?autofocus[panel]=' . $this->panel )
		);
	}
}
