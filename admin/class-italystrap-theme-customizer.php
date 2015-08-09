<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since ItalyStrap 1.0
 */
class ItalyStrap_Theme_Customizer{

	/**
	 * $capability
	 * @var string
	 */
	private $capability = 'edit_theme_options';

	/**
	 * Variable with all CSS
	 * @var string
	 */
	private $style = '';

	function __construct(){

		// Setup the Theme Customizer settings and controls...
		add_action( 'customize_register' , array( $this , 'register' ) );

		// Enqueue live preview javascript in Theme Customizer admin screen
		add_action( 'customize_preview_init' , array( $this , 'live_preview' ) );

		// Output custom CSS to live site
		add_action( 'wp_head' , array( $this , 'css_output' ), 11 );

	}

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 * 
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *  
	 * @see add_action('customize_register',$func)
	 * @param \WP_Customize_Manager $wp_customize
	 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since ItalyStrap 1.0
	 */
	public function register ( $wp_customize ) {



// $wp_customize->add_panel( 'menus', array(
//   'title' => __( 'Menus' ),
//   'description' => 'add_panel', // Include html tags such as <p>.
//   'priority' => 160, // Mixed with top-level-section hierarchy.
// ) );


      //1. Define a new section (if desired) to the Theme Customizer
      // $wp_customize->add_section( 'italystrap_options', 
      //    array(
      //       'title' => __( 'ItalyStrap Options', 'italystrap' ), //Visible title of section
      //       'panel' => 'menus',
      //       'priority' => 0, //Determines what order this appears in
      //       'capability' => 'edit_theme_options', //Capability needed to tweak
      //       'description' => __('Allows you to customize some example settings for ItalyStrap.', 'italystrap'), //Descriptive tooltip
      //    ) 
      // );

		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'link_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default' => '#337ab7', //Default setting/value to save
			'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
			'capability' => $this->capability, //Optional. Special permissions for accessing this setting.
			'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
			$wp_customize, //Pass the $wp_customize object (required)
			'italystrap_link_textcolor', //Set a unique ID for the control
			array(
				'label' => __( 'Link Color', 'italystrap' ), //Admin-visible name of the control
				'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'link_textcolor', //Which setting to load and manipulate (serialized is okay)
				'priority' => 10, //Determines the order this control appears in for the specified section
				) 
			)
		);

		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'hx_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default' => '#333', //Default setting/value to save
			'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
			'capability' => $this->capability, //Optional. Special permissions for accessing this setting.
			'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
			$wp_customize, //Pass the $wp_customize object (required)
			'italystrap_hx_textcolor', //Set a unique ID for the control
			array(
				'label' => __( 'Heading Color', 'italystrap' ), //Admin-visible name of the control
				'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'hx_textcolor', //Which setting to load and manipulate (serialized is okay)
				'priority' => 10, //Determines the order this control appears in for the specified section
				) 
			)
		);

		//4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	}

	/**
	 * Default custom background callback.
	 *
	 * @since 3.0.0
	 * @access protected
	 */
	public function custom_background_cb() {
		// $background is the saved custom image, or the default image.
		$background = set_url_scheme( get_background_image() );

		// $color is the saved custom color.
		// A default has to be specified in style.css. It will not be printed here.
		$color = get_background_color();

		if ( $color === get_theme_support( 'custom-background', 'default-color' ) )
			$color = false;

		if ( ! $background && ! $color )
			return;

		$style = $color ? "background-color:#$color;" : '';

		if ( $background ) {
			$image = " background-image:url('$background');";

			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
				$repeat = 'repeat';

			$repeat = " background-repeat:$repeat;";

			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );

			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
				$position = 'left';

			$position = " background-position: top $position;";

			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
				$attachment = 'scroll';

			$attachment = " background-attachment: $attachment;";

			$style .= $image . $repeat . $position . $attachment;

		}

		$this->style .= 'body.custom-background{' . trim( $style ) . '}';

	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings 
	 * are using 'transport'=>'postMessage' instead of the default 'transport'
	 * => 'refresh'
	 * 
	 * Used by hook: 'customize_preview_init'
	 * 
	 * @see add_action('customize_preview_init',$func)
	 * @since ItalyStrap 1.0
	 */
	public function live_preview() {
		wp_enqueue_script( 
			'italystrap-theme-customizer', // Give the script a unique ID
			ITALYSTRAP_PARENT_PATH . '/admin/js/theme-customizer.min.js', // Define the path to the JS file
			array(  'jquery', 'customize-preview' ), // Define dependencies
			null, // Define a version (optional) 
			true // Specify whether to put in footer (leave this true)
			);
	}

    /**
     * This will generate a line of CSS for use in header or footer output.
     * If the setting ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $property The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors, property and value.
     * @since ItalyStrap 1.0
     */
    public function generate_css( $selector, $property, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

    	/**
    	 * Get theme mod by mod_name
    	 * @var string
    	 */
    	$mod = get_theme_mod( $mod_name );

    	/**
    	 * If mod is empty return
    	 */
		if ( empty( $mod ) )
			return;
		
		/**
		 * CSS style from customizer
		 * @var string
		 */
		$return = $selector . '{' . $property . ':' . $prefix . $mod . $postfix . ';}';

		// if ( $echo )
		// 	echo $return;
		// else
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

		$this->style .= $this->generate_css('#site-title a', 'color', 'header_textcolor', '#');

		$this->style .= $this->generate_css('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6', 'color', 'hx_textcolor' );
		// $css .= $this->generate_css('body.custom-background', 'background-color', 'background_color', '#');
		$this->style .= $this->generate_css('a', 'color', 'link_textcolor');
		// $css .= $this->generate_css('.widget-title,.footer-widget-title', 'border-bottom-color', 'link_textcolor');

		echo '<style type="text/css" id="custom-background-css">' . $this->style . '</style>';

	}

}
/**
 * Initialize Customizer Class
 * @var ItalyStrap_Theme_Customizer
 */
$italystrap_customizer = new ItalyStrap_Theme_Customizer;

/**
 * Fallback function for custom background
 * @return string Return the custom background for body
 */
function italystrap_custom_background_cb(){
    
    global $italystrap_customizer;

    if ( ! $italystrap_customizer )
    	return;

    $italystrap_customizer->custom_background_cb();

}