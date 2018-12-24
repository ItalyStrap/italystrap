<?php
/**
 * Default style_formats configuration
 *
 * Default style_formats configuration for the TinyMCE Editor
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

namespace ItalyStrap\Editors;

return array(
	array(
		'title'	=> __( 'Headers', 'italystrap' ),
		'items'	=> array(
			array(
				'title'		=> __( 'Header 1', 'italystrap' ),
				'format'	=> 'h1',
			),
			array(
				'title'		=> __( 'Header 2', 'italystrap' ),
				'format'	=> 'h2',
			),
			array(
				'title'		=> __( 'Header 3', 'italystrap' ),
				'format'	=> 'h3',
			),
			array(
				'title'		=> __( 'Header 4', 'italystrap' ),
				'format'	=> 'h4',
			),
			array(
				'title'		=> __( 'Header 5', 'italystrap' ),
				'format'	=> 'h5',
			),
			array(
				'title'		=> __( 'Header 6', 'italystrap' ),
				'format'	=> 'h6',
			),
		),
	),
	array(
		'title'	=> __( 'Inline', 'italystrap' ),
		'items'	=> array(
			array(
				'title'		=> 'Bold',
				'icon'		=> 'bold',
				'format'	=> 'bold',
			),
			array(
				'title'		=> 'Italic',
				'icon'		=> 'italic',
				'format'	=> 'italic',
			),
			array(
				'title'		=> 'Underline',
				'icon'		=> 'underline',
				'format'	=> 'underline',
			),
			array(
				'title'		=> 'Strikethrough',
				'icon'		=> 'strikethrough',
				'format'	=> 'strikethrough',
			),
			array(
				'title'		=> 'Superscript',
				'icon'		=> 'superscript',
				'format'	=> 'superscript',
			),
			array(
				'title'		=> 'Subscript',
				'icon'		=> 'subscript',
				'format'	=> 'subscript',
			),
			array(
				'title'		=> 'Code',
				'icon'		=> 'code',
				'format'	=> 'code',
			),
			array(
				'title'		=> 'Small',
				// 'icon'		=> 'small',
				'format'	=> 'small',
				'wrapper'	=> true,
			),
		),
	),
	array(
		'title'	=> __( 'Blocks', 'italystrap' ),
		'items'	=> array(
			array(
				'title'		=> 'Paragraph',
				'format'	=> 'p',
			),
			array(
				'title'		=> 'Blockquote',
				'format'	=> 'blockquote',
			),
			array(
				'title'		=> 'Div',
				'format'	=> 'div',
			),
			array(
				'title'		=> 'Pre',
				'format'	=> 'pre',
			),
		),
	),
	array(
		'title'	=> __( 'Alignment', 'italystrap' ),
		'items'	=> array(
			array(
				'title'		=> 'Left',
				'icon'		=> 'alignleft',
				'format'	=> 'alignleft',
			),
			array(
				'title'		=> 'Center',
				'icon'		=> 'aligncenter',
				'format'	=> 'aligncenter',
			),
			array(
				'title'		=> 'Right',
				'icon'		=> 'alignright',
				'format'	=> 'alignright',
			),
			array(
				'title'		=> 'Justify',
				'icon'		=> 'alignjustify',
				'format'	=> 'alignjustify',
			),
		),
	),
);
