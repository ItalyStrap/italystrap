<?php
/**
 * Array definition for Theme parent sidebar registration.
 * This will be mantained for backward compatibility.
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\HTML;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Definition array() with all the options connected to the
 * module which must be called by an include (setoptions).
 */
return [

	'sidebar-1'		=> [
		'name'				=> __( 'Sidebar', 'italystrap' ),
		'id'				=> 'sidebar-1',
		'before_widget'		=> '<div ' . get_attr( 'sidebar_1', ['id' => '%1$s', 'class' => 'widget %2$s col-sm-6 col-md-12'] ) . '>',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	],

	'footer-box-1'	=> [
		'name'				=> __( 'Footer Box 1', 'italystrap' ),
		'id'				=> 'footer-box-1',
		'description'		=> __( 'Footer box 1 widget area.', 'italystrap' ),
		'before_widget'		=> '<div ' . get_attr( 'footer_box_1', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	],

	'footer-box-2'	=> [
		'name'				=> __( 'Footer Box 2', 'italystrap' ),
		'id'				=> 'footer-box-2',
		'description'		=> __( 'Footer box 2 widget area.', 'italystrap' ),
		'before_widget'		=> '<div ' . get_attr( 'footer_box_2', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	],

	'footer-box-3'	=> [
		'name'				=> __( 'Footer Box 3', 'italystrap' ),
		'id'				=> 'footer-box-3',
		'description'		=> __( 'Footer box 3 widget area.', 'italystrap' ),
		'before_widget'		=> '<div ' . get_attr( 'footer_box_3', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	],

	'footer-box-4'	=> [
		'name'				=> __( 'Footer Box 4', 'italystrap' ),
		'id'				=> 'footer-box-4',
		'description'		=> __( 'Footer box 4 widget area.', 'italystrap' ),
		'before_widget'		=> '<div ' . get_attr( 'footer_box_4', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
		'after_widget' 		=> '</div>',
		'before_title'		=> '<h3 class="widget-title">',
		'after_title'		=> '</h3>',
	],

];
