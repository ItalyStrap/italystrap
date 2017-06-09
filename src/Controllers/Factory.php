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

namespace ItalyStrap\Controllers;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Class description
 */
class Factory {

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
	public function __construct( array $options = array(), $injector, $event_manager ) {
		$this->options = $options;
		$this->injector = $injector;
		$this->event_manager = $event_manager;

		$this->autoload_concrete = array(
			'Navbar_Top'		=> 'ItalyStrap\Controllers\Headers\Navbar_Top',
			'Header_Image'		=> 'ItalyStrap\Controllers\Headers\Image',
			'Nav_Menu'			=> 'ItalyStrap\Controllers\Headers\Nav_Menu',

			'Archive_Headline'	=> 'ItalyStrap\Controllers\Misc\Archive_Headline',
			'Author_Info'		=> 'ItalyStrap\Controllers\Misc\Author_Info',

			'Loop'				=> 'ItalyStrap\Controllers\Posts\Loop',
			'Post'				=> 'ItalyStrap\Controllers\Posts\Post',
			'None'				=> 'ItalyStrap\Controllers\Posts\None',

			'Breadcrumbs'		=> 'ItalyStrap\Controllers\Posts\Parts\Breadcrumbs',
			'Title'				=> 'ItalyStrap\Controllers\Posts\Parts\Title',
			'Meta'				=> 'ItalyStrap\Controllers\Posts\Parts\Meta',
			'Preview'			=> 'ItalyStrap\Controllers\Posts\Parts\Preview',
			'Featured_Image'	=> 'ItalyStrap\Controllers\Posts\Parts\Featured_Image',
			'Content'			=> 'ItalyStrap\Controllers\Posts\Parts\Content',
			'Link_Pages'		=> 'ItalyStrap\Controllers\Posts\Parts\Link_Pages',
			'Modified'			=> 'ItalyStrap\Controllers\Posts\Parts\Modified',
			'Edit_Post_Link'	=> 'ItalyStrap\Controllers\Posts\Parts\Edit_Post_Link',
			'Pager'				=> 'ItalyStrap\Controllers\Posts\Parts\Pager',
			'Pagination'		=> 'ItalyStrap\Controllers\Posts\Parts\Pagination',
			'Password_Form'		=> 'ItalyStrap\Controllers\Posts\Parts\Password_Form',

			'Sidebar'			=> 'ItalyStrap\Controllers\Sidebars\Sidebar',
			'Comments'			=> 'ItalyStrap\Controllers\Comments\Comments',

			'Word_Count'		=> 'ItalyStrap\Schema\Word_Count',
			'Time_Required'		=> 'ItalyStrap\Schema\Time_Required',

			'Footer_Widget_Area'=> 'ItalyStrap\Controllers\Footers\Widget_Area',
			'Colophon'			=> 'ItalyStrap\Controllers\Footers\Colophon',
		);

		$this->autoload_definitions = array(
			'ItalyStrap\Navbar\Navbar'	=> array( 'walker' => 'ItalyStrap\Navbar\Bootstrap_Nav_Menu' ),
		);
	}

	/**
	 * Add action to widget_init
	 * Initialize widget
	 */
	public function register() {

		foreach ( $this->autoload_definitions as $class_name => $class_args ) {
			$this->injector->define( $class_name, $class_args );
		}
		foreach ( $this->autoload_concrete as $implementation ) {

			// if ( is_array( $implementation ) ) {
			// 	$implementation = $implementation[0];
			// }

			$this->injector->share( $implementation );
			$this->event_manager->add_subscriber( $this->injector->make( $implementation ) );
		}

		return null;
	}
}
