<?php

namespace ItalyStrap;

use function \ItalyStrap\Factory\get_config;

/**
 * ====================================================================
 *
 * This file has to be loaded after 'wp' hook
 *
 * @todo Verificare eventuali problemi di priorità con gli hook
 *
 * ====================================================================
 */
return [
//	[
//		'hook'	=> 'italystrap_before_loop',
//		'view'	=> 'posts/index',
//		'data'	=> [],
//		'priority'	=> 10, // Optional
//		'callback'	=> function () {
//			return 'Ciao';
//		}, // Optional
//	],

//	'author-info'	=> [
//		'hook'	=> [
//			[
//				'italystrap_before_loop',
//				20,
//			],
//			[
//				'italystrap_after_entry_content',
//				30,
//			],
//		],
//		'priority'	=> 10, // Optional
//		'callback'	=> '\ItalyStrap\Controllers\Posts\Parts\Breadcrumbs', // Optional
//	],

//	'author-info'	=> [
//		[
//			'hook'		=> 'italystrap_before_loop',
//			'priority'	=> 20, // Optional
//		],
//		[
//			'hook'		=> 'italystrap_after_entry_content',
//			'priority'	=> 30, // Optional
//		],
//		'view'	=> 'misc/author-info',
//		'data'	=> [],
//		'callback'	=> '\ItalyStrap\Controllers\Posts\Parts\Breadcrumbs', // Optional
//	],

		'breadcrumbs'	=> [
			'hook'	=> 'italystrap_before_loop',
			'priority'	=> 10, // Optional
			'callback'	=> '\ItalyStrap\Controllers\Posts\Parts\Breadcrumbs::render', // Optional
		],

		'featured-image'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 10, // Optional
			'view'	=> 'posts/parts/featured-image',
			'data'	=> [],
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Featured_Image::class, 'render' ], // Optional
		],

		'title'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 20, // Optional
			'view'	=> 'posts/parts/title',
			'data'	=> [],
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Title::class, 'render' ], // Optional
		],

		'link-pages'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 20, // Optional
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Link_Pages::class, 'render' ], // Optional
		],

		'meta'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 30, // Optional
			'view'	=> 'posts/parts/meta',
			'data'	=> [],
			'callback'	=> '\ItalyStrap\Controllers\Posts\Parts\Meta::render', // Optional
		],

		'preview'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 40, // Optional
			'view'	=> 'posts/parts/preview',
		],

		'content'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 50, // Optional
			'view'	=> 'posts/parts/content',
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Content::class, 'render' ], // Optional
		],

		'modified'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 60, // Optional
			'view'	=> 'posts/parts/modified',
		],

		'edit-post-link'	=> [
			'hook'	=> 'italystrap_after_entry_content',
			'priority'	=> 999, // Optional
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Edit_Post_Link::class, 'render' ], // Optional
		],

		'pager'	=> [
			'hook'	=> 'italystrap_after_entry_content',
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Pager::class, 'render' ], // Optional
		],

		'pagination'	=> [
			'hook'	=> 'italystrap_after_loop',
			'callback'	=> [ \ItalyStrap\Controllers\Posts\Parts\Pagination::class, 'render' ], // Optional
		],

//		'password-form'	=> [
//			'hook'	=> 'the_password_form',
//			'callback'	=> \ItalyStrap\Controllers\Posts\Parts\Password_Form::class, // Optional
//		],
//
//		'password-form-excerp'	=> [
//			'hook'	=> 'the_excerpt',
//			'callback'	=> \ItalyStrap\Controllers\Posts\Parts\Password_Form::class, // Optional
//		],

		'sidebar'	=> [
			'hook'	=> 'italystrap_after_content',
			'callback'	=> [ \ItalyStrap\Controllers\Sidebars\Sidebar::class, 'render' ], // Optional
		],

	'entry'	=> [
		'hook'	=> 'italystrap_entry',
		'view'	=> 'posts/post',
		'data'	=> function () : array {
			return (array) get_post( null, ARRAY_A );
		},
	],

		/**
		 * ====================================================================
		 *
		 * The content none
		 *
		 * ====================================================================
		 */
		'image-none'	=> [
			'hook'		=> 'italystrap_entry_content_none',
			'view'		=> 'posts/none/image',
		],

		'image-title'	=> [
			'hook'		=> 'italystrap_entry_content_none',
			'view'		=> 'posts/none/image',
			'callback'	=> [ \ItalyStrap\Controllers\Posts\None\Title::class, 'render' ],
		],

		'image-content'	=> [
			'hook'		=> 'italystrap_entry_content_none',
			'view'		=> 'posts/none/image',
			'callback'	=> [ \ItalyStrap\Controllers\Posts\None\Content::class, 'render' ],
		],

	'none'	=> [
		'hook'	=> 'italystrap_content_none',
		'view'	=> 'posts/none',
	],

		'archive-headline'	=> [
			'hook'		=> 'italystrap_before_while',
			'priority'	=> 20,
			'callback'	=> [ \ItalyStrap\Controllers\Misc\Archive_Headline::class, 'render' ],
		],

		'author-info'	=> [
			'hook'		=> 'italystrap_before_loop',
			'priority'	=> 20,
			'callback'	=> [ \ItalyStrap\Controllers\Misc\Author_Info::class, 'render' ],
		],

		'author-info-1'	=> [
			'hook'		=> 'italystrap_after_entry_content',
			'priority'	=> 30,
			'callback'	=> [ \ItalyStrap\Controllers\Misc\Author_Info::class, 'render' ],
		],

	/**
	 * ====================================================================
	 *
	 * The loop
	 *
	 * ====================================================================
	 */
	'loop'	=> [
		'hook'	=> 'italystrap_loop',
		'view'	=> 'posts/loop',
	],

		'navbar-top'	=> [
			'hook'		=> 'italystrap_before_header',
			'callback'	=> [ \ItalyStrap\Controllers\Headers\Navbar_Top::class, 'render' ],
		],

		'header-image'	=> [
			'hook'		=> 'italystrap_content_header',
			'callback'	=> [ \ItalyStrap\Controllers\Headers\Image::class, 'render' ],
		],

		'navbar'	=> [
			'hook'		=> 'italystrap_after_header',
			'callback'	=> [ \ItalyStrap\Controllers\Headers\Nav_Menu::class, 'render' ],
		],

		'comments'	=> [
			'hook'		=> 'italystrap_after_loop',
			'callback'	=> [ \ItalyStrap\Controllers\Comments\Comments::class, 'render' ],
		],

		'footer-widget-area'	=> [
			'hook'		=> 'italystrap_footer',
			'callback'	=> [ \ItalyStrap\Controllers\Footers\Widget_Area::class, 'render' ],
		],

		'footer-colophon'	=> [
			'hook'		=> get_config()->get( 'colophon_action' ),
			'priority'	=> get_config()->get( 'colophon_priority' ),
			'callback'	=> [ \ItalyStrap\Controllers\Footers\Colophon::class, 'render' ],
		],

	/**
	 * ====================================================================
	 *
	 * The base document page
	 *
	 * ====================================================================
	 */
	'index'	=> [
		'hook'	=> 'italystrap',
		'view'	=> 'index',
	],
];
