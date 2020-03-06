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

use ItalyStrap\Config\Config;

use WP_Customize_Manager;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * https://paulund.co.uk/custom-wordpress-controls
 *
 * @since ItalyStrap 1.0
 *
 */
class Theme_Customizer implements SubscriberInterface {

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
			'customize_register'					=> array(
				'function_to_add'	=> 'customize_register',
				'priority'			=> 99,
			),
			'customize_preview_init'				=> 'enqueue_script_on_live_preview',
			'customize_controls_enqueue_scripts'	=> 'enqueue_script_on_customize_controls_enqueue_scripts',
			'admin_menu'							=> 'add_link_to_theme_option_page',
			// 'body_class'							=> 'body_class',
			'italystrap_body_attr'					=> 'body_attr',
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
	 * Init the class
	 */
	function __construct( Config $config ) {
		 $this->theme_mods = $config->all();
	}

	/**
	 * Register the customizer settings
	 *
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * @see add_action( 'customize_register', $func )
	 * @see https://developer.wordpress.org/reference/hooks/customize_register
	 * @see https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/
	 * @link https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/
	 * @link https://iamsteve.me/blog/entry/hero-area-series-wordpress-customizer-with-selective-refresh
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
	public function customize_register( WP_Customize_Manager $manager ) {

		$transport = $manager->selective_refresh ? 'postMessage' : 'refresh';

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
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action( 'customize_preview_init', $func )
	 *
	 * @since ItalyStrap 1.0
	 *
	 */
	public function enqueue_script_on_live_preview() {

		wp_enqueue_script(
			'italystrap-theme-customizer',
			TEMPLATEURL . '/src/Customizer/js/src/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action( 'customize_preview_init', $func )
	 *
	 * @since ItalyStrap 1.0
	 *
	 */
	public function enqueue_script_on_customize_controls_enqueue_scripts() {

		wp_enqueue_script(
			'italystrap-theme-customizer',
			TEMPLATEURL . '/src/Customizer/js/src/customize-controls.js',
			[
				'jquery',
			//				'customize-preview',
			],
			null,
			true
		);
	}

	/**
	 * Used for the breadcrumbs display on customizer with javascript
	 *
	 * @param  array $classes body_class
	 *
	 * @return array          body_class
	 */
	public function body_attr( array $attr ) {

		if ( ! is_customize_preview() ) {
			return $attr;
		}

		$attr['data-current-template'] = CURRENT_TEMPLATE;

		return $attr;
	}

	/**
	 * Function for adding link to Theme Options in case ItalyStrap plugin is active
	 *
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#focusing
	 * autofocus[panel|section|control]=ID
	 */
	public function add_link_to_theme_option_page() {

		add_submenu_page(
			'italystrap-dashboard',
			__( 'Theme Options', 'italystrap' ),
			__( 'Theme Options', 'italystrap' ),
			$this->capability,
			admin_url( 'customize.php?autofocus[panel]=' . $this->panel )
		);
	}
}
