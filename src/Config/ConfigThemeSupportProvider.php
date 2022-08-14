<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Theme\SupportSubscriber;
use ItalyStrap\Theme\ThumbnailsSubscriber;

class ConfigThemeSupportProvider {

	const CUSTOM_HEADER ='custom-header';
	const CUSTOM_LOGO = 'custom-logo';

	private ConfigInterface $config;

	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	public function __invoke(): iterable {
		$logo_size_name_registered = (string)$this->config->get(ConfigSiteLogoProvider::BRAND_IMAGE_SIZE);

		yield SupportSubscriber::class => 	[
			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			'automatic-feed-links',

			/**
			 * Enable support for Post Thumbnails on posts, pages and archives template.
			 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			'post-thumbnails',

			/**
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			'html5'	=> [
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
			],

			/**
			 * Enable support for title-tag.
			 */
			'title-tag',

			/**
			 * Enable support for Post Formats.
			 * See http://codex.wordpress.org/Post_Formats
			 *
			 * @var array
			 */
			'post-formats'	=> [
				'aside',
				'image',
				'gallery',
				'link',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			],

			/**
			 * Custom header value array
			 * Some ideas for default images https://unsplash.it/
			 *
			 * @var array
			 */
			self::CUSTOM_HEADER	=> [
				'default-image'				=> '',
				'width'						=> 1140,
				'height'					=> 200,
				'flex-height'				=> true,
				'flex-width'				=> true,
				'uploads'					=> true,
				'random-default'			=> false,
				'header-text'				=> true,
				'default-text-color'		=> '000',
				'wp-head-callback'			=> '',
				'admin-head-callback'		=> '',
				'admin-preview-callback'	=> '',
				'video'						=> true,
			],

			self::CUSTOM_LOGO	=> [
				'width'       => (int)$this->config->get(
					ThumbnailsSubscriber::class . ".$logo_size_name_registered.width"
				),
				'height'      => (int)$this->config->get(
					ThumbnailsSubscriber::class . ".$logo_size_name_registered.height"
				),
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => ['site-title', 'site-description'],
				'unlink-homepage-logo' => true,
			],

			/**
			 * Custom background support
			 *
			 * @link http://codex.wordpress.org/Custom_Backgrounds
			 * @var array
			 * $defaults = array(
			 *      'default-image'          => '',
			 *		'default-repeat'         => 'repeat',
			 *		'default-position-x'     => 'left',
			 *		'default-attachment'     => 'scroll',
			 *		'default-color'          => '',
			 *		'wp-head-callback'       => '_custom_background_cb',
			 *		'admin-head-callback'    => '',
			 *		'admin-preview-callback' => '',
			 * );
			 *
			 * 'wp-head-callback' => null In case is printed from Theme customizer
			 */
			'custom-background'	=> \apply_filters( 'custom_background_support', [] ),

			/**
			 * @since 4.5 WordPress Core
			 * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
			 */
			'customize-selective-refresh-widgets',

			/**
			 * Add support for the builtin breadcrumbs
			 */
			'breadcrumbs',

			/**
			 * Define and register starter content to showcase the theme on new sites.
			 * @see twentyseventeen
			 * @link https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
			 * @link https://roots.io/using-and-customizing-wordpress-starter-content/
			 *
			 * @link https://gist.github.com/igorbenic/10d22c620fc264aac674f17fbfd07750
			 *
			 * @var array
			 */
			'starter-content'	=> [
				'widgets' => [
					// Place three core-defined widgets in the sidebar area.
					'sidebar-1' => [
						'text_business_info',
						'search',
						'text_about',
						'italystrap_posts',
						// 'text_test'	=> array(
						// 	'text'	=> array(
						// 		'title'	=> 'Title test'
						// 	),
						// ),
					],

					// Add the core-defined business info widget to the footer 1 area.
					'footer-box-1' => [
						'text_business_info',
					],

					// Put two core-defined widgets in the footer 2 area.
					'footer-box-2' => [
						'text_about',
						'search',
					],
				],

				// Specify the core-defined pages to create and add custom thumbnails to some of them.
				'posts' => [
					'home',
					'about' => [
						'thumbnail' => '{{image-sandwich}}',
					],
					'contact' => [
						'thumbnail' => '{{image-default}}',
					],
					'test' => [
						'thumbnail' => '{{image-default}}',
						'post_content'	=> 'POST CONTENT',
					],
					'blog' => [
						'thumbnail' => '{{image-coffee}}',
					],
					'homepage-section' => [
						'thumbnail' => '{{image-default}}',
					],
				],

				// Create the custom image attachments used as post thumbnails for pages.
				'attachments' => [
					'image-default' => [
						'post_title' => _x( 'Default', 'Theme starter content', 'italystrap' ),
						'file' => 'assets/img/italystrap-default-image.png', // URL relative to the template directory.
					],
					'image-sandwich' => [
						'post_title' => _x( 'Sandwich', 'Theme starter content', 'italystrap' ),
						'file' => 'img/images/sandwich.jpg',
					],
					'image-coffee' => [
						'post_title' => _x( 'Coffee', 'Theme starter content', 'italystrap' ),
						'file' => 'img/images/coffee.jpg',
					],
				],

				// Default to a static front page and assign the front and posts pages.
				'options' => [
					'show_on_front' => 'page',
					'page_on_front' => '{{home}}',
					'page_for_posts' => '{{blog}}',
				],

				// Set the front page section theme mods to the IDs of the core-registered pages.
				'theme_mods' => [
					'panel_1' => '{{homepage-section}}',
					'panel_2' => '{{about}}',
					'panel_3' => '{{blog}}',
					'panel_4' => '{{contact}}',
				],

				// Set up nav menus for each of the two areas registered in the theme.
				'nav_menus' => [
					// Assign a menu to the "top" location.
					'info-menu' => [
						'name' => __( 'Info Menu', 'italystrap' ),
						'items' => [
							'link_home', // Note that the core "home" page is actually a
							//link in case a static front page is not used.
							'page_about',
							'page_blog',
							'page_contact',
						],
					],

					// Assign a menu to the "social" location.
					'social-menu' => [
						'name' => __( 'Social Links Menu', 'italystrap' ),
						'items' => [
							'link_yelp',
							'link_facebook',
							'link_twitter',
							'link_instagram',
							'link_email',
							'link_test',
						],
					],

					// Assign a menu to the "social" location.
					'main-menu' => [
						'name' => __( 'Main Menu', 'italystrap' ),
						'items' => [
							'link_home', // Note that the core "home" page is actually a
							//link in case a static front page is not used.
							'page_about',
							'page_blog',
							'page_contact',
							'page_test',
						],
					],
				],
			],

			/** =================================
			 * Theme support for Gutenberg editor
			 *
			 * https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/
			 *
			 * @since WordPress 5.0
			===================================*/

			//		'editor-font-sizes'	=> [
			//			[
			//				'name'      => __( 'Extra Small', 'italystrap' ),
			//				'shortName' => __( 'XS', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 0.75 ),
			//				'slug'      => 'extra-small',
			//			],
			//			[
			//				'name'      => __( 'Small', 'italystrap' ),
			//				'shortName' => __( 'S', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 0.85 ),
			//				'slug'      => 'small',
			//			],
			//			[
			//				'name'      => __( 'Normal', 'italystrap' ),
			//				'shortName' => __( 'M', 'italystrap' ),
			//				'size'      => $font_size_base,
			//				'slug'      => 'normal',
			//			],
			//			[
			//				'name'      => __( 'Large', 'italystrap' ),
			//				'shortName' => __( 'L', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 1.25 ),
			//				//				'unit'		=> 'rem',
			//				'slug'      => 'large',
			//			],
			//			[
			//				'name'      => __( 'Huge', 'italystrap' ),
			//				'shortName' => __( 'XL', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 1.7 ),
			//				'slug'      => 'huge',
			//			],
			//			[
			//				'name'      => __( 'Extra Huge', 'italystrap' ),
			//				'shortName' => __( 'XXL', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 2.15 ),
			//				'slug'      => 'extra-huge',
			//			],
			//			[
			//				'name'      => __( 'H1', 'italystrap' ),
			//				'shortName' => __( 'H1', 'italystrap' ),
			//				'size'      => ceil( $font_size_base * 2.6 ),
			//				'slug'      => 'h1',
			//			],
			//		],

			/**
			 * If the theme support align-wide then activate it
			 */
			'align-wide',

			/**
			 * Support for Gutenberg editor style
			 * Then make sure you are loading the editor-style.css
			 */
			'editor-styles',

			/**
			 * If the theme has dark background then activate it
			 */
			//		'dark-editor-style',

			/**
			 * This will add:
			 * <figure class="wp-embed-aspect-16-9 wp-has-aspect-ratio">...</figure>
			 *
			 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
			 * @TODO
			 */
			'responsive-embeds',

			/**
			 * https://wordpress.org/support/topic/wp-block-styles/
			 * Some blocks in Gutenberg like tables, quotes, separator benefit from structural styles
			 * (margin, padding, border etc…)
			 * They are applied visually only in the editor (back-end) but not on the front-end
			 * to avoid the risk of conflicts with the styles wanted in the theme.
			 * If you want to display them on front to have a base to work with, in this case,
			 * you can add support for wp-block-styles.
			 * You can consult Matias Ventura’s tickets to keep you informed about Gutenberg developments:
			 * https://make.wordpress.org/core/2018/06/05/whats-new-in-gutenberg-5th-june/
			 */
			'wp-block-styles',
		];
	}
}
