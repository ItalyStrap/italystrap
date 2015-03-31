<?php
/**
 * 
 */
class ItalyStrapThemeAdmin{

	/**
	 * Definition of variables containing the configuration
	 * to be applied to the various function calls wordpress
	 */
	protected $capability      = 'manage_options';
	
	function __construct(){
		
		// if ( is_child_theme() )
			add_action('admin_menu', array( $this, 'add_appearance_menu' ));

	}

	public function add_appearance_menu(){
		
		/**
		 * 
		 */
		add_theme_page(
			__( 'ItalyStrap option theme', 'ItalyStrap' ),	// $page_title
			__( 'ItalyStrap option theme', 'ItalyStrap' ),	// $menu_title
			$this->capability,								// $capability
			'italystrap-option-page',						// $menu_slug
			array( $this, 'italystrap_callback_function' )	// $function
			); 
	}

	/**
	 * [italystrap_callback_function description]
	 * @return string [description]
	 */
	public function italystrap_callback_function(){

			if ( !current_user_can( $this->capability ) )
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

		echo "string";
	}
}

if ( is_admin() )
	new ItalyStrapThemeAdmin;