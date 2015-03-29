<?php
/**
 * Add possibility to adding glyphicon directly in new custom field in menu
 * @link http://www.wpexplorer.com/adding-custom-attributes-to-wordpress-menus/
 */
class ItalyStrap_custom_menu {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// load the plugin translation files
		// add_action( 'init', array( $this, 'textdomain' ) );
		
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'italystrap_add_custom_nav_fields' ) );

		// save menu custom fields
		if ( is_admin() )
			add_action( 'wp_update_nav_menu_item', array( $this, 'italystrap_update_custom_nav_fields'), 10, 3 );
		
		// edit menu walker
		if ( is_admin() )
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'italystrap_edit_walker'), 10, 2 );

	} // end constructor
	
	
	/**
	 * Load the plugin's text domain
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'italystrap', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function italystrap_add_custom_nav_fields( $menu_item ) {
	
	    $menu_item->glyphicon = get_post_meta( $menu_item->ID, '_menu_item_glyphicon', true );
	    return $menu_item;
	    
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function italystrap_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	
	    // Check if element is properly sent
	    if ( is_array( $_REQUEST['menu-item-glyphicon']) ) {
	        $glyphicon_value = $_REQUEST['menu-item-glyphicon'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_glyphicon', $glyphicon_value );
	    }
	    
	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function italystrap_edit_walker($walker,$menu_id) {
	
	    return 'Admin_Edit_Custom_Walker_Nav_Menu_Edit_Custom';
	    
	}

}

require_once locate_template( '/core/Admin_Edit_Custom_Walker_Nav_Menu_Edit_Custom.php' );