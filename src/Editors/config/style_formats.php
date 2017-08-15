<?php
/**
 * style_formats configuration
 *
 * style_formats configuration for the TinyMCE Editor
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

namespace ItalyStrap\Editors;

return array(
	array(
		'title'		=> 'Text format',
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> 'Small',
				'block'		=> 'small',
				// 'classes' => 'small',
				'wrapper'	=> true,
			),
			array(
				'title'		=> 'Big',
				'block'		=> 'big',
				// 'classes' => 'small',
				'wrapper'	=> true,
			),
		),
	),
	array(
		'title'		=> 'Colors',
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> 'Text primary',
				'classes'	=> 'text-primary',
				'type'		=> 'item',
				'selector'	=> 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li',
				'exact'		=> false,
			),
			array(
				'title'		=> 'Text inverse',
				'classes'	=> 'text-inverse',
				'type'		=> 'item',
				'selector'	=> 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li',
				'exact'		=> false,
			),
		),
	),
	array(
		'title'		=> 'Grid',
		'type'		=> 'group',
		'items'		=> 	array(
			array(
				'title'		=> 'Row',
				'type'		=> 'item',
				'block'		=> 'div',
				'classes'	=> 'row',
				'wrapper'	=> true,
			),
			array(
				'title'		=> 'Col',
				'block'		=> 'div',
				'classes'	=> 'col',
				'wrapper'	=> true,
			),
		),
	),
	// array(
	// 	'title'		=> 'Big',
	// 	'block'		=> 'big',
	// 	// 'classes' => 'small',
	// 	'wrapper'	=> true,
	// ),
);
