<?php
/**
 * Array definition for Thema parent sidebar registration
 *
 * @package ItalyStrap
 */

if ( ! defined( 'ITALYSTRAP_THEME' ) or ! ITALYSTRAP_THEME ) {
	die();
}

/**
 * Definition array() with all the options connected to the
 * module which must be called by an include (setoptions).
 */
return array(

	'sidebar-1'		=> array(
		'name'				=> __( 'Sidebar', 'ItalyStrap' ),
		'id'				=> 'sidebar-1',
		'before_widget'		=> '<div id="%1$s" class="widget %2$s col-sm-6 col-md-12">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	),

	'footer-box-1'	=> array(
		'name'				=> __( 'Footer Box 1', 'ItalyStrap' ),
		'id'				=> 'footer-box-1',
		'description'		=> __( 'Footer box 1 widget area.', 'ItalyStrap' ),
		'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	),

	'footer-box-2'	=> array(
		'name'				=> __( 'Footer Box 2', 'ItalyStrap' ),
		'id'				=> 'footer-box-2',
		'description'		=> __( 'Footer box 2 widget area.', 'ItalyStrap' ),
		'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	),

	'footer-box-3'	=> array(
		'name'				=> __( 'Footer Box 3', 'ItalyStrap' ),
		'id'				=> 'footer-box-3',
		'description'		=> __( 'Footer box 3 widget area.', 'ItalyStrap' ),
		'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	),

	'footer-box-4'	=> array(
		'name'				=> __( 'Footer Box 4', 'ItalyStrap' ),
		'id'				=> 'footer-box-4',
		'description'		=> __( 'Footer box 4 widget area.', 'ItalyStrap' ),
		'before_widget'		=> '<div id="%1$s" class="widget %2$s">',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	),

);
