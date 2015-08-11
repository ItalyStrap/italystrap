<?php
/**
 * @todo Add list of image size
 * @link http://stackoverflow.com/questions/20101909/wordpress-media-uploader-with-size-select
 */
class ItalyStrapOptionTheme{

	/**
	 * Definition of variables containing the configuration
	 * to be applied to the various function calls wordpress
	 */
	protected $capability = 'manage_options';

	private $options = array();

	private $path;
	
	function __construct(){

		$this->path = get_template_directory_uri();
		// $this->path = get_stylesheet_directory_uri(); // child theme
		
		/**
		 * Add new voice to theme menu
		 */
		add_action('admin_menu', array( $this, 'add_appearance_menu' ));

		/**
		 * Init settings
		 */
		add_action( 'admin_init', array( $this, 'italystrap_theme_settings_init') );

		/**
		 * Enqueue script for upload image functions
		 */
		add_action('admin_enqueue_scripts', array( $this, 'options_enqueue_scripts') );

		/**
		 * Add link to Theme Options in case ItalyStrap plugin is active
		 */
		if ( defined('ITALYSTRAP_PLUGIN') )
			add_action('admin_menu', array( $this, 'add_link_to_theme_option_page') );

	}

	/**
	 * Function for adding link to Theme Options in case ItalyStrap plugin is active
	 * @link http://snippets.webaware.com.au/snippets/add-an-external-link-to-the-wordpress-admin-menu/
	 */
	public function add_link_to_theme_option_page() {
		global $submenu;
		// $url = 'themes.php?page=italystrap-option-page';
		$url = admin_url( 'customize.php?autofocus[control]=italystrap_options' );
		$submenu['italystrap-dashboard'][] = array(
											__( 'Theme Options', 'ItalyStrap' ),
											$this->capability,
											$url);
	}

	/**
	 * Add new menu in theme.php
	 */
	public function add_appearance_menu(){
		
		/**
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_page
		 */
		add_theme_page(
			__( 'ItalyStrap Theme Options', 'ItalyStrap' ),	// $page_title <title></title>
			__( 'Theme Options', 'ItalyStrap' ),			// $menu_title
			$this->capability,								// $capability
			'italystrap-option-page',						// $menu_slug
			array( $this, 'italystrap_callback_function' )	// $function
			);

	}

	/**
	 * Add WordPress standard form for options page
	 * @return string
	 */
	public function italystrap_callback_function(){

			if ( !current_user_can( $this->capability ) )
				wp_die( __( 'You do not have sufficient permissions to access this page.', 'ItalyStrap' ) );

			?>

				<div class="wrap">
					<h2>
						<span class="dashicons dashicons-admin-settings" style="font-size:32px;margin-right:15px"></span> ItalyStrap panel
					</h2>
						<?php // settings_errors(); ?>

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
	 * Initialize otpions
	 */
	public function italystrap_theme_settings_init() {

		/**
		 * Set default options
		 * @var array
		 */
		$default_options = array(
					'default_404'	=>	$this->path . '/img/404.jpg',
					'default_image'	=>	$this->path . '/img/italystrap-default-image.png',
					// 'favicon'		=>	$this->path . '/img/favicon.ico',
					'logo'			=>	$this->path . '/img/italystrap-logo.jpg',
					'analytics'		=>	''
					);

		$this->options = get_option( 'italystrap_theme_settings' );

		/**
		 * If the theme options don't exist, create them.
		 */
		if( false === $this->options )
			add_option( 'italystrap_theme_settings', $default_options );

		/**
		 * @link https://codex.wordpress.org/Function_Reference/add_settings_section
		 */
		add_settings_section(
			'italystrap_option_theme_section', // $id String for use in the 'id' attribute of tags.
			__( 'ItalyStrap options page', 'ItalyStrap' ), //$title Title of the section.
			array( $this, 'theme_settings_section_callback'), // $callback
			'italystrap_theme_options_group' // $page Should match $menu_slug from add_theme_page
			);

		/**
		 * Code for 404
		 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
		 */
		add_settings_field( 
			'default_404', // $id String for use in the 'id' attribute of tags
			__( 'Default image for 404 page', 'ItalyStrap' ), // $id Title of the field
			array( $this, 'option_404'), // $callback 
			'italystrap_theme_options_group', // $page Should match $menu_slug from add_theme_page()
			'italystrap_option_theme_section', // $section
			null // $args Additional arguments that are passed to the $callback function
			);

		/**
		 * Code for default_image
		 */
		add_settings_field( 
			'default_image',
			__( 'Default image', 'ItalyStrap' ),
			array( $this, 'option_default_image'),
			'italystrap_theme_options_group',
			'italystrap_option_theme_section',
			null
			);

		/**
		 * Code for favicon
		 */
		// add_settings_field( 
		// 	'favicon',
		// 	__( 'Favicon', 'ItalyStrap' ),
		// 	array( $this, 'option_favicon'),
		// 	'italystrap_theme_options_group',
		// 	'italystrap_option_theme_section',
		// 	null
		// 	);

		/**
		 * Code for Logo
		 */
		add_settings_field( 
			'logo',
			__( 'Logo', 'ItalyStrap' ),
			array( $this, 'option_logo'),
			'italystrap_theme_options_group',
			'italystrap_option_theme_section',
			null
			);

		/**
		 * Code for analytics
		 */
		add_settings_field( 
			'analytics',
			__( 'Analytics ID', 'ItalyStrap' ),
			array( $this, 'option_analytics'),
			'italystrap_theme_options_group',
			'italystrap_option_theme_section',
			null
			);

		/**
		 * @link https://codex.wordpress.org/Function_Reference/register_setting
		 */
		register_setting(
			'italystrap_theme_options_group', // This must match the group name in settings_fields()
			'italystrap_theme_settings', // The name of an option to sanitize and save.
			array( $this, 'sanitize_callback')
			);


	}

	public function sanitize_callback( $input ){

		$new_input = array();

		if( isset( $input['default_404'] ) )
			$new_input['default_404'] = sanitize_text_field( $input['default_404'] );

		if( isset( $input['default_image'] ) )
			$new_input['default_image'] = sanitize_text_field( $input['default_image'] );

		if( isset( $input['favicon'] ) )
			$new_input['favicon'] = sanitize_text_field( $input['favicon'] );

		if( isset( $input['logo'] ) )
			$new_input['logo'] = sanitize_text_field( $input['logo'] );

		if( isset( $input['analytics'] ) )
			$new_input['analytics'] = sanitize_text_field( $input['analytics'] );

		return $new_input;

	}

	public function theme_settings_section_callback( $arg ) {

		/**
		 * $arg show add_settings_section $id, $title, $callback and $page name
		 */

		_e( 'Manage or enter your settings below: <strong>(It is still in Beta version)</strong>', 'ItalyStrap' );

	}

	public function option_404(){

		$default_404 = ( isset( $this->options['default_404'] ) ) ? esc_url( $this->options['default_404'] ) : '' ;

		?>
		<div id="option_404">
			<input type="text" id="default_404" name="italystrap_theme_settings[default_404]" value="<?php echo esc_url( $default_404 ); ?>" />
			<input id="upload_404_button" type="button" class="button upload_button" value="<?php _e( 'Upload default 404 image', 'ItalyStrap' ); ?>" />
			<span class="description"><?php _e('Upload an image for the 404.php page (at least width 750px).', 'ItalyStrap' ); ?></span>
			<h4  style="margin:0"><?php _e( 'Default 404 image preview', 'ItalyStrap' ); ?></h4>
			<p>
				<img src="<?php echo esc_url( $default_404 ); ?>" width="150px" class="img-preview">
			</p>
		</div>
		<?php

	}

	public function option_default_image(){

		$default_image = ( isset( $this->options['default_image'] ) ) ? esc_url( $this->options['default_image'] ) : '' ;

		?>
		<div id="option_default_image">
			<input type="text" id="default_image" name="italystrap_theme_settings[default_image]" value="<?php echo esc_url( $default_image ); ?>" />
			<input id="upload_default_image_button" type="button" class="button upload_button" value="<?php _e( 'Upload default image', 'ItalyStrap' ); ?>" />
			<span class="description"><?php _e('Upload an image for the default image used for social share (must be 1200x600px).', 'ItalyStrap' ); ?></span>
			<h4  style="margin:0"><?php _e( 'Default image preview', 'ItalyStrap' ); ?></h4>
			<p>
				<img src="<?php echo esc_url( $default_image ); ?>" width="150px" class="img-preview">
			</p>
		</div>
		<?php

	}

	public function option_favicon(){

		$favicon = ( isset( $this->options['favicon'] ) ) ? esc_url( $this->options['favicon'] ) : '' ;

		?>
		<div id="option_favicon">
			<input type="text" id="favicon" name="italystrap_theme_settings[favicon]" value="<?php echo esc_url( $favicon ); ?>" />
			<input id="upload_favicon_button" type="button" class="button upload_button" value="<?php _e( 'Upload favicon', 'ItalyStrap' ); ?>" />
			<span class="description"><?php _e('Upload an image for the favicon (max 32x32px).', 'ItalyStrap' ); ?></span>
			<h4  style="margin:0"><?php _e( 'Favicon preview', 'ItalyStrap' ); ?></h4>
			<p>
				<img src="<?php echo esc_url( $favicon ); ?>" width="16px" class="img-preview">
			</p>
		</div>
		<?php

	}

	public function option_logo(){

		$logo = ( isset( $this->options['logo'] ) ) ? esc_url( $this->options['logo'] ) : '' ;

		?>
		<div id="option_logo">
			<input type="text" id="logo" name="italystrap_theme_settings[logo]" value="<?php echo esc_url( $logo ); ?>" />
			<input id="upload_logo_button" type="button" class="button upload_button" value="<?php _e( 'Upload Logo', 'ItalyStrap' ); ?>" />
			<span class="description"><?php _e('Upload an image for the logo.', 'ItalyStrap' ); ?></span>
			<h4  style="margin:0"><?php _e( 'Logo preview', 'ItalyStrap' ); ?></h4>
			<p>
				<img src="<?php echo esc_url( $logo ); ?>" width="150px" class="img-preview">
			</p>
		</div>
		<?php

	}

	public function option_analytics(){

		$analytics = ( isset( $this->options['analytics'] ) ) ? esc_textarea( $this->options['analytics'] ) : '' ;

		?>
		<input type="text" id="analytics" name="italystrap_theme_settings[analytics]" value="<?php echo esc_textarea( $analytics ); ?>" placeholder="UA-XXXXX-X" />
		<span class="description"><?php _e('Enter your analytics ID (e.g. UA-XXXXX-X ).', 'ItalyStrap' ); ?></span>
		<?php

	}

	function options_enqueue_scripts() {

		global $path;
		global $pathchild;

		wp_register_script( 'italystrap-upload', $path .'/admin/js/italystrap-upload.js', array('jquery','media-upload','thickbox') );

		if ( 'appearance_page_italystrap-option-page' === get_current_screen() -> id ) {

			wp_enqueue_script('jquery');
			wp_enqueue_media();
			wp_enqueue_script('italystrap-upload');

		}

	}

}

// if ( is_admin() && ! is_child_theme() )
// 	new ItalyStrapOptionTheme;