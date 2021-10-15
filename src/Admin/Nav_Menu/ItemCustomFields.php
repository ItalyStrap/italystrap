<?php
declare(strict_types=1);

namespace ItalyStrap\Admin\Nav_Menu;

use Generator;
use \ItalyStrap\Event\SubscriberInterface;
use WP_Post;
use WP_Term;
use function array_merge;
use function check_admin_referer;
use function delete_post_meta;
use function esc_attr;
use function esc_html;
use function get_post_meta;
use function ItalyStrap\HTML\get_attr as attr;
use function printf;
use function sprintf;
use function uniqid;
use function update_post_meta;

/**
 * Add possibility to adding glyphicon directly in new custom field in menu
 *
 *
 * Based on {@link https://twitter.com/westonruter Weston Ruter}'s {@link https://gist.github.com/3802459 gist}
 * and on {@link https://github.com/Codeinwp/menu-item-custom-fields}
 *
 * @version 1.0.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 *
 * @forked from ItalyStrap
 * @package ItalyStrap
 * @since 4.0.0
 * @uses Walker_Nav_Menu_Edit
 * @deprecated
 */
final class ItemCustomFields implements SubscriberInterface {

	/**
	 * Holds our custom fields
	 *
	 * @var array
	 */
	private $fields = array();

	/**
	 * @var string
	 */
	private $key_pattern;

	/**
	 * Init the constructor
	 */
	public function __construct() {
		$this->key_pattern = 'menu-item-%s';
		$this->setFields(
			[
				[
					'type' => 'text',
					'id' => 'glyphicon',
					'name' => 'glyphicon',
					'label' => __( 'Icon css class', 'italystrap' ),
					'desc' => __( 'Example: fa fa-icon fa-3x', 'italystrap' ),
				],
			]
		);
	}

	/**
	 * Print field
	 *
	 * @param int $id Nav menu ID.
	 * @param object $item Menu item data object.
	 */
	public function printFields( $id, $item ) {

		foreach ($this->getFields() as $field) :
			$field = array_merge( $this->defaultField(), $field );
			$key = sprintf( $this->key_pattern, $field[ 'id' ] );
			$id = sprintf( 'edit-%s-%s', $key, $item->ID );
			$name = sprintf( '%s[%s]', $key, $item->ID );
			$value = (string)get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $field[ 'id' ] );
			?>
			<p class="description description-wide <?php echo esc_attr( $class ) ?>">
				<?php
					$attributes = attr(
						$key,
						[
							'type' => $field[ 'type' ],
							'id' => '%1$s',
							'class' => 'widefat %1$s',
							'name' => '%3$s',
							'value' => '%4$s',
						]
					);

				printf(
					'<label for="%1$s">%2$s<br /><input' . $attributes . '/></label>',
					esc_attr( $id ),
					esc_html( $field[ 'label' ] ),
					esc_attr( $name ),
					esc_attr( $value )
				) ?>
				<br>
				<?php echo esc_html( $field[ 'desc' ] ) ?>
			</p>
			<?php
		endforeach;
	}

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @param WP_Post|WP_Term $menu_item Menu item data object.
	 *
	 * @return WP_Post|WP_Term            New menu item data object.
	 */
	public function addCustomNavFields( $menu_item ) {

		foreach ($this->getFields() as $field) {
			$var = $field[ 'id' ];
			$menu_item->$var = get_post_meta( $menu_item->ID, sprintf( $this->key_pattern, $var ), true );
		}

		return $menu_item;
	}

	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int $menu_id Nav menu ID
	 * @param int $menu_item_db_id Menu item ID
	 * @param array $menu_item_args Menu item data
	 */
	public function saveFields( int $menu_id, int $menu_item_db_id, array $menu_item_args ) {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ($this->getFields() as $field) {
			$key = sprintf( $this->key_pattern, $field[ 'id' ] );

			if ( empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				delete_post_meta( $menu_item_db_id, $key );
				continue;
			}

			update_post_meta( $menu_item_db_id, $key, sanitize_text_field( $_POST[ $key ][ $menu_item_db_id ] ) );
		}
	}

	/**
	 * Define new Walker edit
	 *
	 * @param string $class The walker class to use.
	 *                         Default 'Walker_Nav_Menu_Edit'.
	 * @param int $menu_id The menu id, derived from $_POST['menu'].
	 *
	 * @return string          The new walker class to use.
	 */
	public function register() {
		return NavMenuEdit::class;
	}

	/**
	 * Add our fields to the screen options toggle
	 *
	 * @param array $columns Menu item columns
	 *
	 * @return array
	 */
	public function columns( $columns ): array {
		return array_merge( $columns, iterator_to_array( $this->getColumns() ) );
	}

	/**
	 * @return Generator
	 */
	private function getColumns() {
		foreach ($this->getFields() as $field) {
			yield $field[ 'id' ] => $field[ 'label' ];
		}
	}

	/**
	 * @return array
	 */
	private function getFields(): array {
		return $this->fields;
	}

	/**
	 * @param array $fields
	 */
	private function setFields( array $fields ) {
		$this->fields = $fields;
	}

	/**
	 * @return array
	 */
	private function defaultField(): array {

		$uniqid = uniqid();

		return [
			'type' => 'text',
			'id' => $uniqid,
			'name' => $uniqid,
			'label' => __( 'Label not provided', 'italystrap' ),
			'desc' => '',
		];
	}

	/**
	 * Returns an array of events (hooks) that this subscriber wants to register with
	 * the Events Manager API.
	 *
	 * The array key is the name of the hook. The value can be:
	 *
	 *  * The method name
	 *  * An array with the method name and priority
	 *  * An array with the method name, priority and number of accepted arguments
	 *
	 * For instance:
	 *
	 * array(
	 *     // 'event_name'             => 'method_name',
	 *     'italystrap_before_header'  => 'render',
	 * )
	 * array(
	 *     // 'event_name'                     => 'method_name',
	 *     'italystrap_before_entry_content'   => array(
	 *         'function_to_add'   => 'render',
	 *         'priority'          => 30, // Default 10
	 *         'accepted_args'     => 1 // Default 1
	 *     ),
	 * );
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): iterable {

		/**
		 * Add new checkboxes to the "Screen options" menu
		 */
		yield 'manage_nav-menus_columns'      => [
			SubscriberInterface::CALLBACK       => 'columns',
			SubscriberInterface::PRIORITY       => 11,
		];

		/**
		 * Add the value fro new custom fields to the object in the Nav Walker
		 */
		yield 'wp_setup_nav_menu_item'        => 'addCustomNavFields';

		/**
		 * Save the value
		 */
		yield 'wp_update_nav_menu_item'       => [
			SubscriberInterface::CALLBACK       => 'saveFields',
			SubscriberInterface::PRIORITY       => 10,
			SubscriberInterface::ACCEPTED_ARGS  => 3,
		];

		/**
		 * Display the added custom fields
		 */
		yield 'wp_nav_menu_item_custom_fields' => [
			SubscriberInterface::CALLBACK       => 'printFields',
			SubscriberInterface::PRIORITY       => 10,
			SubscriberInterface::ACCEPTED_ARGS  => 5,
		];

//		return [

			/**
			 * Register new class for Menu Edit
			 */
//			'wp_edit_nav_menu_walker' => [
//				SubscriberInterface::CALLBACK => 'register',
//				'accepted_args' => 2,
//			],

			/**
			 * Add new checkboxes to the "Screen options" menu
			 */
//			'manage_nav-menus_columns'      => [
//				SubscriberInterface::CALLBACK       => 'columns',
//				SubscriberInterface::PRIORITY       => 11,
//			],

			/**
			 * Add the value fro new custom fields to the object in the Nav Walker
			 */
//			'wp_setup_nav_menu_item'        => 'addCustomNavFields',

			/**
			 * Save the value
			 */
//			'wp_update_nav_menu_item'       => [
//				SubscriberInterface::CALLBACK       => 'saveFields',
//				SubscriberInterface::PRIORITY       => 10,
//				SubscriberInterface::ACCEPTED_ARGS  => 3,
//			],

			/**
			 * Display the added custom fields
			 */
//			'wp_nav_menu_item_custom_fields' => [
//				SubscriberInterface::CALLBACK       => 'printFields',
//				SubscriberInterface::PRIORITY       => 10,
//				SubscriberInterface::ACCEPTED_ARGS  => 5,
//			],
//		];
	}
}
