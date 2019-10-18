<?php
/**
 * Array definition for Theme parent sidebar registration.
 * This will be mantained for backward compatibility.
 *
 * @package ItalyStrap
 */
declare(strict_types=1);
namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag, close_tag, get_attr};

/**
 * @todo In questi settings vengono registrate anche le widget_area
 *       del footer che la key viene usate per calcolare la larghezza della colonna.
 *       Vedi Classe Footer_Widget_area
 */
return apply_filters( 'italystrap_sidebars_registered',
	[
		'sidebar-1'		=> [
			'name'				=> __( 'Sidebar', 'italystrap' ),
			'id'				=> 'sidebar-1',
			'before_widget'		=> '<div ' . get_attr( 'sidebar_1', ['id' => '%1$s', 'class' => 'widget %2$s col-sm-6 col-md-12'] ) . '>',
			'after_widget'		=> '</div>',
//			'before_title'		=> '<h3 class="widget-title">',
//			'after_title'		=> '</h3>',
		],

		'footer-box-1'	=> [
			'name'				=> __( 'Footer Box 1', 'italystrap' ),
			'id'				=> 'footer-box-1',
			'description'		=> __( 'Footer box 1 widget area.', 'italystrap' ),
//			'before_widget'		=> '<div ' . get_attr( 'footer_box_1', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
//			'after_widget' 		=> '</div>',
//			'before_title'		=> '<h3 class="widget-title">',
//			'after_title'		=> '</h3>',
		],

		'footer-box-2'	=> [
			'name'				=> __( 'Footer Box 2', 'italystrap' ),
			'id'				=> 'footer-box-2',
			'description'		=> __( 'Footer box 2 widget area.', 'italystrap' ),
//			'before_widget'		=> '<div ' . get_attr( 'footer_box_2', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
//			'after_widget' 		=> '</div>',
//			'before_title'		=> '<h3 class="widget-title">',
//			'after_title'		=> '</h3>',
		],

		'footer-box-3'	=> [
			'name'				=> __( 'Footer Box 3', 'italystrap' ),
			'id'				=> 'footer-box-3',
			'description'		=> __( 'Footer box 3 widget area.', 'italystrap' ),
//			'before_widget'		=> '<div ' . get_attr( 'footer_box_3', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
//			'after_widget' 		=> '</div>',
//			'before_title'		=> '<h3 class="widget-title">',
//			'after_title'		=> '</h3>',
		],

		'footer-box-4'	=> [
			'name'				=> __( 'Footer Box 4', 'italystrap' ),
			'id'				=> 'footer-box-4',
			'description'		=> __( 'Footer box 4 widget area.', 'italystrap' ),
//			'before_widget'		=> '<div ' . get_attr( 'footer_box_4', ['id' => '%1$s', 'class' => 'widget %2$s'] ) . '>',
//			'after_widget' 		=> '</div>',
//			'before_title'		=> '<h3 class="widget-title">',
//			'after_title'		=> '</h3>',
		],

	]
);
