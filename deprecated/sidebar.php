<?php
_deprecated_file( basename(__FILE__), 'ItalyStrap 3.0.6', 'core/class-italystrap-sidebars.php', __( 'This file is deprecated, please use class-italystrap-sidebars.php instead', 'ItalyStrap' ) );

//Registro l'area widget classica nella sidebar
if (function_exists('register_sidebar')){
	
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div class="widget %2$s  col-sm-6 col-md-12">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Box 1', 'ItalyStrap' ),
		'id' => 'footer-box-1',
		'description' => __( 'Footer box 1 widget area (Use only a widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 2', 'ItalyStrap' ),
		'id' => 'footer-box-2',
		'description' => __( 'Footer box 2 widget area (Use only a widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 3', 'ItalyStrap' ),
		'id' => 'footer-box-3',
		'description' => __( 'Footer box 3 widget area (Use only a widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 4', 'ItalyStrap' ),
		'id' => 'footer-box-4',
		'description' => __( 'Footer box 4 widget area (Use only a widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}