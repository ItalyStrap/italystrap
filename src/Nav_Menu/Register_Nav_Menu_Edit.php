<?php
/**
 * Handle the Navigation Menu API: Walker_Nav_Menu_Edit class.
 *
 * @package ItalyStrap\Core
 * @uses Walker_Nav_Menu
 *
 * @since 3.0.0
 */

namespace ItalyStrap\Nav_Menu;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Add possibility to adding glyphicon directly in new custom field in menu
 *
 * @link http://www.wpexplorer.com/adding-custom-attributes-to-wordpress-menus/
 */
class Register_Nav_Menu_Edit implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked wp_setup_nav_menu_item - 10
	 * @hooked wp_update_nav_menu_item - 10
	 * @hooked wp_edit_nav_menu_walker - 10
	 * @hooked wp_fields_nav_menu_item - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_setup_nav_menu_item'	=> 'add_custom_nav_fields',
			'wp_update_nav_menu_item'	=> array(
				'function_to_add'	=> 'update_custom_nav_fields',
				'priority'			=> 10,
				'accepted_args'		=> 3,
			),
			'wp_fields_nav_menu_item'	=> array(
				'function_to_add'	=> 'add_new_field',
				'priority'			=> 10,
				'accepted_args'		=> 2,
			),
			'wp_edit_nav_menu_walker'	=> array(
				'function_to_add'	=> 'register',
				'priority'			=> 10,
				'accepted_args'		=> 2,
			),
		);
	}

	/**
	 * Init the constructor
	 *
	 * @param array $options The plugin options.
	 * @param array $args    The class arguments.
	 */
	public function __construct( array $options = array(), array $args = array() ) {
		$this->args = array( 'glyphicon' );
	}

	/**
	 * Add new field to Custom_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit
	 *
	 * @param  WP_Post $item    Menu item data object.
	 * @param  int     $item_id The ID of the item.
	 */
	public function add_new_field( $item, $item_id ) {

	?>
	<p class="field-custom description description-wide">
		<label for="edit-menu-item-glyphicon-<?php echo $item_id; // XSS ok. ?>">
			<?php _e( 'Glyphicon or your icon class', 'ItalyStrap' ); // XSS ok. ?>
			<input type="text" id="edit-menu-item-glyphicon-<?php echo $item_id; // XSS ok. ?>" class="widefat code edit-menu-item-custom" name="menu-item-glyphicon[<?php echo $item_id; // XSS ok. ?>]" value="<?php echo esc_attr( $item->glyphicon ); // XSS ok. ?>" />
		</label>
	</p>
	<?php

	}

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @param  WP_Post $menu_item Menu item data object.
	 * @return WP_Post            New menu item data object.
	 */
	function add_custom_nav_fields( $menu_item ) {

		foreach ( $this->args as $key => $value ) {
			$menu_item->$value = get_post_meta( $menu_item->ID, '_menu_item_' . $value, true );
		}

		return $menu_item;

	}

	/**
	 * Save menu custom fields
	 *
	 * @param  int   $menu_id         The ID of the menu.
	 * @param  int   $menu_item_db_id The ID of the menu item.
	 * @param  array $menu_item_data  The menu item's data.
	 */
	function update_custom_nav_fields( $menu_id, $menu_item_db_id, $menu_item_data ) {

		$glyphicon = isset( $_REQUEST['menu-item-glyphicon'] )
			? $_REQUEST['menu-item-glyphicon']
			: null;

		if ( ! $glyphicon ) {
			return;
		}

		if ( ! is_array( $glyphicon ) ) {
			return;
		}

		if ( ! isset( $glyphicon[ $menu_item_db_id ] ) ) {
			return;
		}

		update_post_meta( $menu_item_db_id, '_menu_item_glyphicon', sanitize_text_field( $glyphicon[ $menu_item_db_id ] ) );

	}

	/**
	 * Define new Walker edit
	 *
	 * @param  string $class   The walker class to use.
	 *                         Default 'Walker_Nav_Menu_Edit'.
	 * @param  int    $menu_id The menu id, derived from $_POST['menu'].
	 *
	 * @return string          The new walker class to use.
	 */
	function register( $class, $menu_id ) {

		return '\ItalyStrap\Nav_Menu\Nav_Menu_Edit';
	}
}
