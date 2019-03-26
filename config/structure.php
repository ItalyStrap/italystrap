<?php

namespace ItalyStrap;

use \ItalyStrap\Config\Config_Interface;
use function \ItalyStrap\Factory\get_config;
use function ItalyStrap\Factory\get_injector;

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

		'breadcrumbs'	=> [
			'hook'	=> 'italystrap_before_loop',
			'priority'	=> 10, // Optional
			'should_load'	=> function () {
				return current_theme_supports( 'breadcrumbs' )
					&& in_array( CURRENT_TEMPLATE, explode( ',', get_config()->get( 'breadcrumbs_show_on' ) ), true )
					&& ! \in_array( 'hide_breadcrumbs', Core\get_template_settings(), true );
			},
			'callback'	=> function () {
				$args = array(
					'home'	=> '<i class="glyphicon glyphicon-home" aria-hidden="true"></i>',
				);

				do_action( 'do_breadcrumbs', $args );
			},
		],

		'featured-image'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 10, // Optional
			'should_load'	=> function () {
				return \post_type_supports( \get_post_type(), 'thumbnail' )
					&& ! \in_array( 'hide_thumb', Core\get_template_settings(), true );
			},
			'view'	=> 'posts/parts/featured-image',
			'data'	=> function ( Config_Interface $config ) : Config_Interface {
				if ( is_singular() ) {
					$config->push( 'post_thumbnail_size', 'post-thumbnail' );
					$config->push( 'post_thumbnail_alignment', 'aligncenter' );
				}

				return $config;
			},
		],

		'title'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 20, // Optional
			'should_load'	=> function () : bool {
				return \post_type_supports( \get_post_type(), 'title' )
					&& ! \in_array( 'hide_title', Core\get_template_settings(), true );
			},
			'view'	=> 'posts/parts/title',
		],

		'link-pages'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 25, // Optional
			'should_load'	=> function () : bool {
				return is_single();
			},
			'callback'	=> [ Components\Navigations\Link_Pages::class, 'render' ], // Optional
		],

		'meta'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 30, // Optional
			'should_load'	=> function () : bool {
				return post_type_supports( get_post_type(), 'entry-meta' )
					&& ! \in_array( 'hide_meta', Core\get_template_settings(), true );
			},
			'view'	=> 'posts/parts/meta',
		],

		'preview'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 40, // Optional
			'view'	=> 'posts/parts/preview',
		],

		'content'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 50, // Optional
			'should_load'	=> function () : bool {

				/**
				 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
				 * || ! post_type_supports( $post_type, 'excerpt' )
				 * @todo Vadere di fare un controllo sulle pagine perchè ovviamente non hanno il riassunto
				 *       e con il controllo sopra sparisce il contenuto e non va bene.
				 */
				return post_type_supports( get_post_type(), 'editor' )
					&& ! \in_array( 'hide_content', Core\get_template_settings(), true );
			},
			'view'	=> 'posts/parts/content',
		],

		'modified'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 60, // Optional
			'view'	=> 'posts/parts/modified',
		],

//		'edit-post-link'	=> [
//			'hook'	=> 'italystrap_after_entry_content',
//			'priority'	=> 999, // Optional
//			'callback'	=> [ Controllers\Posts\Parts\Edit_Post_Link::class, 'render' ], // Optional
//		],

		'pager'	=> [
			'hook'	=> 'italystrap_after_entry_content',
			'should_load'	=> function () : bool {
				return \post_type_supports( \get_post_type(), 'post_navigation' )
					&& is_single();
			},
			'callback'	=> [ Components\Navigations\Pager::class, 'render' ], // Optional
		],

		'pagination'	=> [
			'hook'	=> 'italystrap_after_loop',
			'should_load'	=> function () : bool {
				return ! is_404();
			},
			'callback'	=> [ Components\Navigations\Pagination::class, 'render' ], // Optional
		],

//		'password-form'	=> [
//			'hook'	=> 'the_password_form',
//			'callback'	=> Controllers\Posts\Parts\Password_Form::class, // Optional
//		],
//
//		'password-form-excerp'	=> [
//			'hook'	=> 'the_excerpt',
//			'callback'	=> Controllers\Posts\Parts\Password_Form::class, // Optional
//		],

		'sidebar'	=> [
			'hook'	=> 'italystrap_after_content',
			'callback'	=> '\get_sidebar',
			'should_load'	=> function () : bool {
				return 'full_width' !== get_config()->get( 'site_layout' );
			},
			/**
			 * @TODO Maybe for WooCommerce, for now is only for remember
			 */
			'callback_to_develope'	=> function () {

				/**
				 * Don't load sidebar on pages that doesn't need it
				 */
				if ( 'full_width' === get_config()->get( 'site_layout' ) ) {
					/**
					 * This hook is usefull for example when you need to remove the
					 * WooCommerce sidebar on full width page.
					 *
					 * @example
					 * add_action( 'italystrap_full_width_layout', function () {
					 *     remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
					 * }, 10 );
					 */
					do_action( 'italystrap_full_width_layout' );
					return;
				}

				\get_sidebar();

		//		if ( in_array( $this->layout->get_layout_settings(), array(), true ) ) {
		//			get_sidebar( 'secondary' );
		//		}
			}, // Optional
		],

	'entry'	=> [
		'hook'	=> 'italystrap_entry',
		'view'	=> 'posts/post',
		'data'	=> function () : array {
			return (array) \get_post( null, ARRAY_A );
		},
	],

		/**
		 * ====================================================================
		 *
		 * The content none components
		 *
		 * ====================================================================
		 */
		'none-image'	=> [
			'hook'			=> 'italystrap_entry_content_none',
			'view'			=> 'posts/none/image',
		],

		'none-title'	=> [
			'hook'			=> 'italystrap_entry_content_none',
			'priority'		=> 20,
			'view'			=> 'posts/none/title',
			'data'			=> function ( Config_Interface $config ) : Config_Interface {
				return $config;
			},
		],

		'none-content'	=> [
			'hook'			=> 'italystrap_entry_content_none',
			'priority'		=> 30,
			'view'			=> 'posts/none/content',
			'data'			=> function ( Config_Interface $config ) : Config_Interface {
				return $config;
			},
		],

	'none'	=> [
		'hook'	=> 'italystrap_content_none',
		'view'	=> 'posts/none',
	],

		'archive-headline'	=> [
			'hook'		=> 'italystrap_before_while',
			'priority'	=> 20,
			'view'		=> 'misc/archive-headline',
			'should_load'	=> function () {
				return ( \is_archive() || \is_search() ) && ! \is_author();
			},
		],

		'author-info'	=> [
			'hook'		=> 'italystrap_before_loop',
			'priority'	=> 20,
			'callback'	=> [ Controllers\Misc\Author_Info::class, 'render' ],
		],

		'author-info-1'	=> [
			'hook'		=> 'italystrap_after_entry_content',
			'priority'	=> 30,
			'callback'	=> [ Controllers\Misc\Author_Info::class, 'render' ],
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
		'view'	=> ['posts/loop'],
	],

		'navbar-top'	=> [
			'hook'		=> 'italystrap_before_header',
			'view'		=> 'headers/navbar-top',
			'should_load'	=> function () : bool {
				return \has_nav_menu( 'info-menu' )
					&& \has_nav_menu( 'social-menu' );
			},
		],

		'header-image'	=> [
			'hook'		=> 'italystrap_content_header',
			'callback'	=> [ Controllers\Headers\Image::class, 'render' ],
		],

		'navbar'	=> [
			'hook'		=> 'italystrap_after_header',
			'view'		=> 'headers/navbar',
			'data'	=> function () {
				return [
					'navbar'	=> get_injector()->make( '\ItalyStrap\Navbar\Navbar' ),
				];
			},
		],

		/**
		 * @example it could be added new key 'callback_args' for additional or custom callback arguments
		 * 			They will be provisioned to the callback itself.
		 *
		 * "callback_args => [ 'file' => 'new_comment_template.php' ]"
		 */
		'comments'	=> [
			'hook'		=> 'italystrap_after_loop',
			'callback'	=> '\comments_template',
			'should_load'	=> function () : bool {
				return \is_singular()
					&& \post_type_supports( \get_post_type(), 'comments' )
					&& ! \in_array( 'hide_comments', Core\get_template_settings(), true );
			},
		],

		'footer-widget-area'	=> [
			'hook'		=> 'italystrap_footer',
			'view'		=> 'footers/widget-area',
			'callback'	=> [ Components\Footers\Widget_Area::class, 'render' ],
		],

		'footer-colophon'	=> [
			'hook'		=> get_config()->get( 'colophon_action' ),
			'priority'	=> get_config()->get( 'colophon_priority' ),
			'view'		=> 'footers/colophon',
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
