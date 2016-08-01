<?php

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

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @todo https://codex.wordpress.org/Function_Reference/header_textcolor
 * @todo https://github.com/overclokk/wordpress-theme-customizer-custom-controls
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/
 * @since ItalyStrap 1.0
 */
class Customizer{

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
	 * The default text for colophon
	 *
	 * @var string
	 */
	private $colophon_default_text = '';

	/**
	 * Init the class
	 */
	function __construct() {

		$this->colophon_default_text = apply_filters( 'italystrap_colophon_default_text', Core\colophon_default_text() );
	}

	/**
	 * Function for adding link to Theme Options in case ItalyStrap plugin is active
	 *
	 * @link http://snippets.webaware.com.au/snippets/add-an-external-link-to-the-wordpress-admin-menu/
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#focusing
	 * autofocus[panel|section|control]=ID
	 */
	public function add_link_to_theme_option_page() {

		global $submenu;
		/**
		 * Link to customizer
		 *
		 * @link http://wptheming.com/2015/01/link-to-customizer-sections/
		 * @var string
		 */
		$url = admin_url( 'customize.php?autofocus[panel]=italystrap_options_page' );
		$submenu['italystrap-dashboard'][] = array(
			__( 'Theme Options', 'ItalyStrap' ),
			$this->capability,
			$url,
		);
	}

	/**
	 * Add new menu in theme.php
	 */
	public function add_appearance_menu() {

		/**
		 * Add theme page
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_page
		 */
		add_theme_page(
			__( 'ItalyStrap Theme Info', 'ItalyStrap' ),// $page_title <title></title>
			__( 'ItalyStrap Theme Info', 'ItalyStrap' ),// $menu_title.
			$this->capability,							// $capability.
			'italystrap-theme-info',					// $menu_slug.
			array( $this, 'callback_function' )			// $function.
		);

	}

	/**
	 * Add WordPress standard form for options page
	 */
	public function callback_function() {

		if ( ! current_user_can( $this->capability ) ) {
			wp_die( esc_attr__( 'You do not have sufficient permissions to access this page.', 'ItalyStrap' ) );
		}

		?>

			<div class="wrap">
				<h2>
					<span class="dashicons dashicons-admin-settings" style="font-size:32px;margin-right:15px"></span> ItalyStrap panel
				</h2>
				<form action='options.php' method='post'>
					
					<?php
					settings_fields( 'italystrap_theme_options_group' );
					do_settings_sections( 'italystrap_theme_options_group' );
					submit_button();
					?>
					
				</form>
			</div>

		<?php

	}

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see add_action('customize_register',$func)
	 * @param  object $wp_customize The cutomizer object.
	 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since ItalyStrap 1.0
	 */
	public function register_init( $wp_customize ) {

		require(  TEMPLATEPATH . '/admin/settings/settings-customize.php'  );

		// Hide core sections/controls when they aren't used on the current page.
		// $wp_customize->get_section( 'header_image' )->active_callback = 'is_front_page';
		// $wp_customize->get_control( 'blogdescription' )->active_callback = 'is_front_page';
		$this->set_theme_mod_from_options();

		do_action( 'italystrap_after_customize_register', $wp_customize );

	}

	/**
	 * Retrieves the attachment ID from the file URL
	 *
	 * @link https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
	 * @param  string $image_url The src of the image.
	 * @return int               Return the ID of the image
	 */
	private function pippin_get_image_id( $image_url ) {

		$attachment = wp_cache_get( 'get_image_id' . $image_url );

		if ( false === $attachment ) {

			global $wpdb;
			$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
			wp_cache_set( 'get_image_id' . $image_url, $attachment );
		}

		$attachment[0] = ( isset( $attachment[0] ) ) ? $attachment[0] : null;

		return absint( $attachment[0] );

	}

	/**
	 * Esporto le opzioni precedentemente registrate in options e le carico nelle opzioni del tema
	 */
	public function set_theme_mod_from_options() {

		/**
		 * Rendo globale la variabile delle opzioni
		 */
		global $italystrap_options;

		if ( ! $italystrap_options ) {
			return;
		}

		foreach ( $italystrap_options as $key => $value ) {

			if ( ! get_theme_mod( $key ) && preg_match( '#png|jpg|gif#is', $italystrap_options[ $key ] ) ) {

				set_theme_mod( $key, $this->pippin_get_image_id( $italystrap_options[ $key ] ) );
			} elseif ( ! get_theme_mod( $key ) ) {

				set_theme_mod( $key, $italystrap_options[ $key ] );

			}

			/**
			 * Test
			 * var_dump( $key . ' => ' . get_theme_mod( $key ) );
			 * remove_theme_mod( $key );
			 */

		}

		/**
		 * Test
		 * remove_theme_mod( 'colophon' );
		 * var_dump(get_theme_mods());
		 */
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
			ITALYSTRAP_PARENT_PATH . '/admin/js/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);

	}

	/**
	 * Default custom background callback.
	 *
	 * @since 3.0.0
	 * @access protected
	 */
	public function custom_background_cb() {

		/**
		 * $background is the saved custom image, or the default image.
		 *
		 * @var string
		 */
		$background = set_url_scheme( get_background_image() );

		/**
		 * $color is the saved custom color.
		 * A default has to be specified in style.css. It will not be printed here.
		 *
		 * @var string
		 */
		$color = get_background_color();

		if ( get_theme_support( 'custom-background', 'default-color' ) === $color ) {
			$color = false;
		}

		if ( ! $background && ! $color ) {
			return;
		}

		$style = $color ? 'background-color:#' . $color . ';' : '';

		if ( $background ) {
			$image = 'background-image:url(' . $background . ');';

			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ), true ) ) {
				$repeat = 'repeat';
			}

			$repeat = 'background-repeat:' . $repeat . ';';

			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );

			if ( ! in_array( $position, array( 'center', 'right', 'left' ), true ) ) {
				$position = 'left';
			}

			$position = 'background-position: top ' . $position . ';';

			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ), true ) ) {
				$attachment = 'scroll';
			}

			$attachment = 'background-attachment: ' . $attachment . ';';

			$style .= $image . $repeat . $position . $attachment;

		}

		$this->style .= 'body.custom-background{' . trim( $style ) . '}';

	}

	/**
	 * This will generate a line of CSS for use in header or footer output.
	 * If the setting ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses get_theme_mod()
	 * @param string $selector CSS selector.
	 * @param string $property The name of the CSS *property* to modify.
	 * @param string $mod_name The name of the 'theme_mod' option to fetch.
	 * @param string $prefix Optional. Anything that needs to be output before the CSS property.
	 * @param string $postfix Optional. Anything that needs to be output after the CSS property.
	 * @param bool   $echo Optional. Whether to print directly to the page (default: true).
	 * @return string Returns a single line of CSS with selectors, property and value.
	 * @since ItalyStrap 1.0
	 */
	public function generate_css( $selector, $property, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

		/**
		 * Get theme mod by mod_name
		 *
		 * @var string
		 */
		$mod = get_theme_mod( $mod_name );

		/**
		 * If mod is empty return
		 */
		if ( empty( $mod ) ) {
			return;
		}

		/**
		 * CSS style from customizer
		 *
		 * @var string
		 */
		$return = $selector . '{' . $property . ':' . $prefix . $mod . $postfix . ';}';

		return $return;

	}

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see add_action('wp_head',$func)
	 * @see add_action('wp_footer',$func)
	 * @since ItalyStrap 1.0
	 */
	public function css_output() {

		global $italystrap_theme_mods;

		/**
		 * Custom CSS section on customizer page
		 *
		 * @var string
		 */
		$custom_css = ( isset( $italystrap_theme_mods['custom_css'] ) ) ? $italystrap_theme_mods['custom_css'] : '' ;

		$this->style .= $this->generate_css( '#site-title a', 'color', 'header_textcolor', '#' );

		$this->style .= $this->generate_css( 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading', 'color', 'hx_textcolor' );
		/**
		 * $css .= $this->generate_css('body.custom-background', 'background-color', 'background_color', '#');
		 */
		$this->style .= $this->generate_css( 'a', 'color', 'link_textcolor' );
		/**
		 * $css .= $this->generate_css('.widget-title,.footer-widget-title', 'border-bottom-color', 'link_textcolor');
		 */

		$this->style .= $custom_css;

		$this->style .= apply_filters( 'italystrap_css_output', $this->style );

		echo '<style type="text/css" id="custom-background-css">' . esc_attr( $this->minify_output( $this->style ) ) . '</style>';

	}

	/**
	 * Minify the CSS output
	 *
	 * @param  string $css The CSS output.
	 * @return string      The CSS minified
	 */
	public function minify_output( $css ) {

		return $css = str_replace(
			array(
				"\n",
				"\r",
				"\t",
				'&amp;nbsp;',
				),
			'',
			$css
		);
	}
}

/**
 * Fallback function for custom background.
 */
function italystrap_custom_background_cb() {

	global $italystrap_customizer;

	if ( ! $italystrap_customizer ) {
		$italystrap_customizer = new Customizer;
	}

	$italystrap_customizer->custom_background_cb();

}
