<?php
/**
 * Theme configuration file.
 *
 * This is the configuration settings of the theme, you can override the value by filters.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

return array(

	/**
	 * Add theme support functionality
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support
	 */
	'add_theme_support'	=> array(

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		'automatic-feed-links',

		/**
		 * Enable support for Post Thumbnails on posts, pages and archives template.
		 *
		 * @see ItalyStrap\Core\Image\Size() for set_post_thumbnail_size()
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		'post-thumbnails',

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		'html5'	=> array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		),

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
		'post-formats'	=> array(
			'aside',
			'image',
			'gallery',
			'link',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		),

		/**
		 * Custom header value array
		 * Some ideas for default images https://unsplash.it/
		 *
		 * @var array
		 */
		'custom-header'	=> array(
			'default-image'          => '',
			'width'                  => 1140,
			'height'                 => 400,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => true,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		),

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
		 * @see ItalyStrap\Core\Css\Css::custom_background_cb()
		 */
		'custom-background'	=> array(
			'wp-head-callback' => array( $this->css_manager, 'custom_background_cb' ),
		),

		/**
		 * @since 4.5 WordPress Core
		 * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
		 */
		'customize-selective-refresh-widgets',

		/**
		 * Define and register starter content to showcase the theme on new sites.
		 * @see twentyseventeen
		 * @link https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/
		 *
		 * @var array
		 */
		'starter-content'	=> array(
			'widgets' => array(
				// Place three core-defined widgets in the sidebar area.
				'sidebar-1' => array(
					'text_business_info',
					'search',
					'text_about',
				),

				// Add the core-defined business info widget to the footer 1 area.
				'sidebar-2' => array(
					'text_business_info',
				),

				// Put two core-defined widgets in the footer 2 area.
				'sidebar-3' => array(
					'text_about',
					'search',
				),
			),

			// Specify the core-defined pages to create and add custom thumbnails to some of them.
			'posts' => array(
				'home',
				'about' => array(
					'thumbnail' => '{{image-sandwich}}',
				),
				'contact' => array(
					'thumbnail' => '{{image-espresso}}',
				),
				'blog' => array(
					'thumbnail' => '{{image-coffee}}',
				),
				'homepage-section' => array(
					'thumbnail' => '{{image-espresso}}',
				),
			),

			// Create the custom image attachments used as post thumbnails for pages.
			'attachments' => array(
				'image-espresso' => array(
					'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
					'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
				),
				'image-sandwich' => array(
					'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
					'file' => 'assets/images/sandwich.jpg',
				),
				'image-coffee' => array(
					'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
					'file' => 'assets/images/coffee.jpg',
				),
			),

			// Default to a static front page and assign the front and posts pages.
			'options' => array(
				'show_on_front' => 'page',
				'page_on_front' => '{{home}}',
				'page_for_posts' => '{{blog}}',
			),

			// Set the front page section theme mods to the IDs of the core-registered pages.
			'theme_mods' => array(
				'panel_1' => '{{homepage-section}}',
				'panel_2' => '{{about}}',
				'panel_3' => '{{blog}}',
				'panel_4' => '{{contact}}',
			),

			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus' => array(
				// Assign a menu to the "top" location.
				'top' => array(
					'name' => __( 'Top Menu', 'twentyseventeen' ),
					'items' => array(
						'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
						'page_about',
						'page_blog',
						'page_contact',
					),
				),

				// Assign a menu to the "social" location.
				'social' => array(
					'name' => __( 'Social Links Menu', 'twentyseventeen' ),
					'items' => array(
						'link_yelp',
						'link_facebook',
						'link_twitter',
						'link_instagram',
						'link_email',
					),
				),
			),
		),

	),
);

