<?php
/**
* Class for registering sidebars in template
* There are a standard sidebar and 4 footer dynamic sidebars
*/
class ItalyStrap_Sidebars{

	/**
	 * Init sidebars registration
	 */
	function __construct(){

		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

	}

	/**
	 * Register Sidebar in template on widget_init
	 * @return string Register sidebars in sidebar and footer
	 */
	public function register_sidebars(){

		register_sidebar( array(
			'name' => 'Sidebar',
			'id' => 'sidebar-1',
			'before_widget' => '<div id="%2$s" class="widget %2$s  col-sm-6 col-md-12">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		register_sidebar( array(
			'name' => __( 'Footer Box 1', 'ItalyStrap' ),
			'id' => 'footer-box-1',
			'description' => __( 'Footer box 1 widget area (Use only a widget)', 'ItalyStrap' ),
			'before_widget' => '<div id="%2$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Footer Box 2', 'ItalyStrap' ),
			'id' => 'footer-box-2',
			'description' => __( 'Footer box 2 widget area (Use only a widget)', 'ItalyStrap' ),
			'before_widget' => '<div id="%2$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Footer Box 3', 'ItalyStrap' ),
			'id' => 'footer-box-3',
			'description' => __( 'Footer box 3 widget area (Use only a widget)', 'ItalyStrap' ),
			'before_widget' => '<div id="%2$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Footer Box 4', 'ItalyStrap' ),
			'id' => 'footer-box-4',
			'description' => __( 'Footer box 4 widget area (Use only a widget)', 'ItalyStrap' ),
			'before_widget' => '<div id="%2$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		// register_sidebars(4, array(
		// 	'name' => __( 'Footer Box %d', 'ItalyStrap' ),
		// 	'id' => 'footer-box',
		// 	'class' => 'footer',
		// 	'description' => __( 'Footer box widget area (Use only a widget)', 'ItalyStrap' ),
		// 	'before_widget' => '<div id="%2$s" class="widget %2$s col-md-3">',
		// 	'after_widget'  => '</div>',
		// 	'before_title' => '<h3 class="widget-title">',
		// 	'after_title' => '</h3>',
		// ) );

	}

	/**
	 * Set col-x number for sidebars style
	 * @see footer.php The file to display footer 
	 */
	public function set_col(){

		global $sidebars_widgets;
		$this->sidebars_widgets = $sidebars_widgets;

		/**
		 * unset for retrieve only footer sidebars
		 */
		unset( $this->sidebars_widgets['wp_inactive_widgets'] );
		unset( $this->sidebars_widgets['sidebar-1'] );

		$count = 0;
		foreach ($this->sidebars_widgets as $key => $value)
			if (!empty($value))
				$count++;

		$count = ( $count === 0 ) ? 1 : $count ;
		
		return $col =  floor(12 / $count );

	}

}