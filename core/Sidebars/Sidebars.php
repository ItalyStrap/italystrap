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

namespace ItalyStrap\Core\Sidebars;

/**
* Class for registering sidebars in template
* There are a standard sidebar and 4 footer dynamic sidebars
*/
class Sidebars{

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

		$this->sidebars = (array) apply_filters( 'italystrap_sidebars_registered', require( TEMPLATEPATH . '/config/sidebars.php' ) );

		$this->footer_sidebars = apply_filters(
			'footer_sidebars_widgets',
			array(
			'footer-box-1',
			'footer-box-2',
			'footer-box-3',
			'footer-box-4',
			)
		);
	}

	/**
	 * Register Sidebar in template on widget_init
	 */
	public function register_sidebars() {

		foreach ( $this->sidebars as $key => $value ) {
			register_sidebar( $value );
		}

		// register_sidebars(4, array(
		// 	'name'				=> __( 'Footer Box %d', 'ItalyStrap' ),
		// 	'id'				=> 'footer-box',
		// 	'class'				=> 'footer',
		// 	'description'		=> __( 'Footer box widget area.', 'ItalyStrap' ),
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

	/**
	 * Set col-x number for sidebars style
	 *
	 * @see footer.php The file to display footer
	 */
	public function set_col() {

		global $sidebars_widgets, $wp_registered_widgets, $wp_registered_widget_controls;

		$count = 0;

		foreach ( $this->footer_sidebars as $value ) {

			if ( ! empty( $sidebars_widgets[ $value ][0] ) ) {

				$count++;
			}
		}

		$count = ( 0 === $count ) ? 1 : $count ;

		return $col = floor( 12 / $count );

	}
}
