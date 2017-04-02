<?php
/**
 * Template Factory
 *
 * Manage the Template Classes and load the theme
 *
 * @link https://italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Templates;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Template_Factory {

	/**
	 * The plugin's options
	 *
	 * @var string
	 */
	private $options = '';

	/**
	 * List of all widget classes name.
	 *
	 * @var array
	 */
	private $widget_list = array();

	/**
	 * Injector object
	 *
	 * @var null
	 */
	private $injector = null;

	/**
	 * Fire the construct
	 */
	public function __construct( array $options = array(), $injector = null, $event_manager = null ) {
		$this->options = $options;
		$this->injector = $injector;
		$this->event_manager = $event_manager;

		$this->registered_template_classes = array(
			'Navbar_Top'		=> '\ItalyStrap\Core\Templates\Navbar_Top',
			'Header_Image'		=> '\ItalyStrap\Core\Templates\Header_Image',
			'Nav_Menu'			=> '\ItalyStrap\Core\Templates\Nav_Menu',
			'Breadcrumbs'		=> '\ItalyStrap\Core\Templates\Breadcrumbs',
			'Archive_Headline'	=> '\ItalyStrap\Core\Templates\Archive_Headline',
			'Author_Info'		=> '\ItalyStrap\Core\Templates\Author_Info',
			'Loop'				=> '\ItalyStrap\Core\Templates\Loop',
			'Entry'				=> '\ItalyStrap\Core\Templates\Entry',
			'Title'				=> array(
				'\ItalyStrap\Core\Templates\Title',
				// 35,
			),
			'Meta'				=> '\ItalyStrap\Core\Templates\Meta',
			'Preview'			=> '\ItalyStrap\Core\Templates\Preview',
			'Featured_Image'	=> '\ItalyStrap\Core\Templates\Featured_Image',
			'Content'			=> '\ItalyStrap\Core\Templates\Content',
			'Link_Pages'		=> '\ItalyStrap\Core\Templates\Link_Pages',
			'Modified'			=> '\ItalyStrap\Core\Templates\Modified',
			'Edit_Post_Link'	=> '\ItalyStrap\Core\Templates\Edit_Post_Link',
			'Pager'				=> '\ItalyStrap\Core\Templates\Pager',
			'Pagination'		=> '\ItalyStrap\Core\Templates\Pagination',
			'None'				=> '\ItalyStrap\Core\Templates\None',
			'Sidebar'			=> '\ItalyStrap\Core\Templates\Sidebar',
			'Comments'			=> '\ItalyStrap\Core\Templates\Comments',
			'Password_Form'		=> '\ItalyStrap\Core\Templates\Password_Form',
			'Word_Count'		=> '\ItalyStrap\Core\Schema\Word_Count',
			'Time_Required'		=> '\ItalyStrap\Core\Schema\Time_Required',
			'Footer_Widget_Area'=> '\ItalyStrap\Core\Templates\Footer_Widget_Area',
			'Colophon'			=> '\ItalyStrap\Core\Templates\Colophon',
		);
	}

	/**
	 * Add action to widget_init
	 * Initialize widget
	 */
	public function register() {

		$container = array();

		$this->injector->define(
			'\ItalyStrap\Core\Navbar\Navbar',
			array( 'walker' => '\ItalyStrap\Core\Navbar\Bootstrap_Nav_Menu' )
		);

		foreach ( $this->registered_template_classes as $class_name => $value ) {

			$class_name = strtolower( $class_name );
			$prefixed_classname = "italystrap_{$class_name}";

			if ( is_array( $value ) ) {
				add_filter( "italystrap_{$class_name}_priority", function ( $priority ) use ( $value ) {
					if ( ! isset( $value[1] ) ) {
						return $priority;
					}
					return $value[1];
				});

				$value = $value[0];
			}

			$$prefixed_classname = $this->injector->make( $value );
			$this->event_manager->add_subscriber( $$prefixed_classname );
			// $container[ $prefixed_classname ] = $$prefixed_classname;
		}

		// return $container;
		return null;
	}

	/**
	 * Test
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function test() {
	
		$test_registered_template = array(

			'Title'	=> array(
				'\ItalyStrap\Core\Templates\Title'	=> array(
					'italystrap_entry_content'	=> array(
						'function_to_add'	=> 'render', // forse non serve
						'priority'			=> 10,
					),
				),
			),
		);
		// foreach ( $test_registered_template as $class_name => $value ) {

			// d( $value[1][0] );

			// $class_name = strtolower( $class_name );
			// $prefixed_classname = "italystrap_{$class_name}";



			// $$prefixed_classname = $injector->make( $value[0] );

			// add_action(
			// 	$value[1][0],
			// 	array( $$prefixed_classname, $value[1]['function_to_add'] ),
			// 	isset( $value[1]['priority'] ) ? $value[1]['priority'] : 10,
			// 	isset( $value[1]['accepted_args'] ) ? $value[1]['accepted_args'] : 1
			// );
			// $event_manager->add_subscriber( $$prefixed_classname );
		// }
	
	}
}
