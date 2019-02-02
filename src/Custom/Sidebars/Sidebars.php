<?php
/**
 * [Short Description (no period for file headers)]
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

namespace ItalyStrap\Custom\Sidebars;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
* Class for registering sidebars in template
* There are a standard sidebar and 4 footer dynamic sidebars
*/
class Sidebars implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked widgets_init - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'widgets_init'	=> 'register_sidebars',
		);
	}

	/**
	 * This is a variable with options for registering sidebars
	 *
	 * @var array
	 */
	private $sidebars = array();

	/**
	 * The footer sidebars options
	 *
	 * @var array
	 */
	private $footer_sidebars = array();

	/**
	 * Init sidebars registration
	 */
	function __construct() {

		/**
		 * @todo In questi settings vengono registrate anche le widget_area
		 *       del footer che la key viene usate per calcolare la larghezza della colonna.
		 *       Vedi Classe Footer_Widget_area
		 */
		$this->sidebars = (array) apply_filters( 'italystrap_sidebars_registered', require PARENTPATH . '/config/sidebars.php' );
	}

	/**
	 * Register Sidebar in template on widget_init
	 */
	public function register_sidebars() {

		foreach ( $this->sidebars as $key => $value ) {
			register_sidebar( $value );
		}

		// register_sidebars(4, array(
		// 	'name'				=> __( 'Footer Box %d', 'italystrap' ),
		// 	'id'				=> 'footer-box',
		// 	'class'				=> 'footer',
		// 	'description'		=> __( 'Footer box widget area.', 'italystrap' ),
		// 	'before_widget'		=> '<div id="%2$s" class="widget %2$s col-md-3">',
		// 	'after_widget' 		=> '</div>',
		// 	'before_title'		=> '<h3 class="widget-title">',
		// 	'after_title'		=> '</h3>',
		// ) );

		// if ( function_exists('register_sidebar') ){
		// 	/*extract all parent pages */
		// 	$topLevel = get_pages(array(
		// 		'sort_column' => 'post_date',
		// 		'hierarchical' => 0,
		// 		'parent' => 0
		// 		));

		// 	foreach($topLevel as $page){
		// 		/* register sidebar for each parent page */
		// 		register_sidebar(array(  
		// 			'name' => $page->post_title,  
		// 			'id'   => 'sidebar-'.$page->post_name, 
		// 			'description'   => 'This widget display on page "'.$page->post_title.'"',  
		// 			'before_widget' => '<div id="%2$s" class="widget">',
		// 			'after_widget'  => '</div>',  
		// 			'before_title'  => '<h2>',  
		// 			'after_title'   => '</h2>'  
		// 			));
		// 	}
		// }
	}
}
