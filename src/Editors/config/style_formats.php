<?php
/**
 * style_formats configuration
 *
 * style_formats configuration for the TinyMCE Editor
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 * @link https://www.tinymce.com/docs/configure/content-formatting/#formats
 *
 * @link italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap\Editors
 */

namespace ItalyStrap\Editors;

$selectors = 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,span';

return array(
	array(
		'title'		=> __( 'Text size', 'italystrap' ),
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> __( 'Big', 'italystrap' ),
				'inline'	=> 'big',
				// 'classes' => 'small',
				// 'wrapper'	=> true,
				// 'exact'		=> false,
			),
			array(
				'title'		=> __( 'Small', 'italystrap' ),
				'inline'	=> 'small',
				// 'classes' => 'small',
				// 'wrapper'	=> true,
				// 'exact'		=> false,
			),
			array(
				'title'		=> __( 'H1', 'italystrap' ),
				'classes'	=> 'h1',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'H2', 'italystrap' ),
				'classes'	=> 'h2',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'H3', 'italystrap' ),
				'classes'	=> 'h3',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'H4', 'italystrap' ),
				'classes'	=> 'h4',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'H5', 'italystrap' ),
				'classes'	=> 'h5',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'H6', 'italystrap' ),
				'classes'	=> 'h6',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
		),
	),
	array(
		'title'		=> __( 'Text colors', 'italystrap' ),
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> __( 'Text primary', 'italystrap' ),
				'classes'	=> 'text-primary',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'Text secondary', 'italystrap' ),
				'classes'	=> 'text-secondary',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			array(
				'title'		=> __( 'Text inverse', 'italystrap' ),
				'classes'	=> 'text-inverse',
				'type'		=> 'item',
				// 'selector'	=> $selectors,
				'inline'	=> 'span',
				'exact'		=> true,
			),
			// array(
			// 	'title'		=> __( 'Text black', 'italystrap' ),
			// 	// 'classes'	=> 'text-inverse',
			// 	'styles'	=> '{color : "%value"}',
			// 	'type'		=> 'item',
			// 	'selector'	=> $selectors,
			// 	'exact'		=> false,
			// ),
		),
	),
	array(
		'title'		=> __( 'Highlight text', 'italystrap' ),
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> __( 'Mark', 'italystrap' ),
				'block'		=> 'mark',
				'wrapper'	=> true,
			),
		),
	),
	array(
		'title'		=> __( 'Button style', 'italystrap' ),
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> __( 'Button Primary', 'italystrap' ),
				'classes'	=> 'btn btn-primary',
				'type'		=> 'item',
				'selector'	=> 'a,button',
				'exact'		=> false,
			),
			array(
				'title'		=> __( 'Button Large', 'italystrap' ),
				'classes'	=> 'btn-lg',
				'type'		=> 'item',
				'selector'	=> 'a,button',
				'exact'		=> false,
			),
			array(
				'title'		=> __( 'Button small', 'italystrap' ),
				'classes'	=> 'btn-sm',
				'type'		=> 'item',
				'selector'	=> 'a,button',
				'exact'		=> false,
			),
			array(
				'title'		=> __( 'Button block', 'italystrap' ),
				'classes'	=> 'btn-block',
				'type'		=> 'item',
				'selector'	=> 'a,button',
				'exact'		=> false,
			),
		),
	),
	// array(
	// 	'title'		=> __( 'Grid', 'italystrap' ),
	// 	'type'		=> 'group',
	// 	'items'		=> 	array(
	// 		array(
	// 			'title'		=> __( 'BT Row', 'italystrap' ),
	// 			'type'		=> 'item',
	// 			'block'		=> 'div',
	// 			'classes'	=> 'row',
	// 			'wrapper'	=> true,
	// 		),
	// 		array(
	// 			'title'		=> __( 'BT Col', 'italystrap' ),
	// 			'block'		=> 'div',
	// 			'classes'	=> 'col',
	// 			'wrapper'	=> true,
	// 		),
	// 	),
	// ),
	// array(
	// 	'title'		=> 'Big',
	// 	'block'		=> 'big',
	// 	// 'classes' => 'small',
	// 	'wrapper'	=> true,
	// ),
);
