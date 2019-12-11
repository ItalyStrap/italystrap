<?php
declare(strict_types=1);
namespace ItalyStrap;

use \ItalyStrap\Config\ConfigInterface;
use function \ItalyStrap\Factory\get_config;
use function \ItalyStrap\Factory\injector;
use function \ItalyStrap\Core\get_template_settings;

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
			'should_load'	=> function () : bool {
				return \current_theme_supports( 'breadcrumbs' )
					&& \in_array( CURRENT_TEMPLATE, \explode( ',', get_config()->get( 'breadcrumbs_show_on' ) ), true )
					&& ! \in_array( 'hide_breadcrumbs', get_template_settings(), true );
			},
			'callback'	=> function (): string {
				$args = [
//					'home'	=> '<i class="glyphicon glyphicon-home" aria-hidden="true"></i>',
				];

				\ob_start();
				\do_action( 'do_breadcrumbs', $args );
				return \strval( \ob_get_clean() );
			},
		],

		'featured-image'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 10, // Optional
			'should_load'	=> function () : bool {
				return \post_type_supports( \strval( \get_post_type() ), 'thumbnail' )
					&& ! \in_array( 'hide_thumb', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/featured-image',
			'data'	=> function ( ConfigInterface $config ) : ConfigInterface {
				if ( \is_singular() ) {
					$config->add( 'post_thumbnail_size', 'post-thumbnail' );
					$config->add( 'post_thumbnail_alignment', 'aligncenter' );
				}

				return $config;
			},
		],

		'title'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 20, // Optional
			'should_load'	=> function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'title' )
					&& ! \in_array( 'hide_title', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/title',
//			'data'	=> function ( ConfigInterface $config ) : ConfigInterface {
//					$config->push( 'title', \get_the_title() );
//				return $config;
//			},
		],

		'meta'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 30, // Optional
			'should_load'	=> function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'entry-meta' )
					&& ! \in_array( 'hide_meta', get_template_settings(), true );
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
				return \post_type_supports(  \strval( \get_post_type() ), 'editor' )
					&& ! \in_array( 'hide_content', get_template_settings(), true );
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

		'link-pages'	=> [
			'hook'	=> 'italystrap_entry_content',
			'priority'	=> 70, // Optional
			'should_load'	=> function () : bool {
				return \is_single();
			},
			'callback'	=> [ Components\Navigations\Link_Pages::class, 'render' ], // Optional
		],

		'pager'	=> [
			'hook'	=> 'italystrap_after_entry_content',
			'should_load'	=> function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'post_navigation' )
					&& \is_single();
			},
			'callback'	=> [ Components\Navigations\Pager::class, 'render' ], // Optional
		],

		'pagination'	=> [
			'hook'	=> 'italystrap_after_loop',
			'should_load'	=> function () : bool {
				return ! \is_404();
			},
			'callback'	=> [ Components\Navigations\Pagination::class, 'render' ], // Optional
		],

		'sidebar'	=> [
			'hook'	=> 'italystrap_after_content',
			'callback'	=> '\get_sidebar',
			'should_load'	=> function () : bool {
				return 'full_width' !== get_config()->get( 'site_layout' );
			},
			/**
			 * @TODO Maybe for WooCommerce, for now is only for remember
			 */
//			'callback_to_develope'	=> function () {
//
//				/**
//				 * Don't load sidebar on pages that doesn't need it
//				 */
//				if ( 'full_width' === get_config()->get( 'site_layout' ) ) {
//					/**
//					 * This hook is usefull for example when you need to remove the
//					 * WooCommerce sidebar on full width page.
//					 *
//					 * @example
//					 * add_action( 'italystrap_full_width_layout', function () {
//					 *     remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
//					 * }, 10 );
//					 */
//					do_action( 'italystrap_full_width_layout' );
//					return;
//				}
//
//				\get_sidebar();
//
//		//		if ( in_array( $this->layout->get_layout_settings(), array(), true ) ) {
//		//			get_sidebar( 'secondary' );
//		//		}
//			}, // Optional
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
			'data'			=> function ( ConfigInterface $config ) : ConfigInterface {
				return $config;
			},
		],

		'none-content'	=> [
			'hook'			=> 'italystrap_entry_content_none',
			'priority'		=> 30,
			'view'			=> 'posts/none/content',
			'data'			=> function ( ConfigInterface $config ) : ConfigInterface {
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
			'should_load'	=> function () : bool {
				return ( \is_archive() || \is_search() ) && ! \is_author();
			},
		],

		'author-info'	=> [
			'hook'		=> 'italystrap_before_loop',
			'priority'	=> 20,
			'view'		=> 'misc/author-info',
			'should_load'	=> 'is_author',
			'data'		=> function () : array {

				$data = [];
				global $author_name;
				$data['author'] = \array_key_exists( 'author_name', $_GET )
					? \get_user_by( 'slug', $author_name )
					: \get_userdata( \absint( \get_the_author_meta( 'ID' ) ) );


				$data['contact'] = injector()->make( '\ItalyStrap\User\Contact_Method_List' );

				return $data;
			},
		],
		// @todo Rename the key with a better name
		'author-info-1'	=> [
			'hook'		=> 'italystrap_after_entry_content',
			'priority'	=> 30,
			'view'		=> 'misc/author-info',
			'should_load'	=> function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'author' )
					&& \is_singular()
					&& ! \in_array( 'hide_author', get_template_settings(), true );
			},
			'data'		=> function () : array {

				$data = [];
				global $author_name;
				$data['author'] = \array_key_exists( 'author_name', $_GET )
					? \get_user_by( 'slug', $author_name )
					: \get_userdata( \absint( \get_the_author_meta( 'ID' ) ) );


				$data['contact'] = injector()->make( '\ItalyStrap\User\Contact_Method_List' );

				return $data;
			},
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
			'view'		=> 'headers/image',
			'should_load'	=> '\has_header_image',
			'data'		=> function () {
				return injector()->make( Components\Headers\Image::class )->get_data();
			},
		],

		'navbar'	=> [
			'hook'		=> 'italystrap_after_header',
			'view'		=> 'headers/navbar',
			'data'	=> function () : array {
				return [
					'navbar'	=> injector()->make( '\ItalyStrap\Components\Navigations\Navbar' ),
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
					&& \post_type_supports( \strval( \get_post_type() ), 'comments' )
					&& ! \in_array( 'hide_comments', get_template_settings(), true );
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
