<?php
/**
 * Setup Theme Functions
 */
if ( !function_exists('ItalyStrap_theme_setup') ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
    function ItalyStrap_theme_setup() {
        
        /*
         * Make theme available for translation.
         */
        load_theme_textdomain( 'ItalyStrap', get_template_directory() . '/lang' );

        /**
         * Add default posts and comments RSS feed links to head.
         */
        add_theme_support('automatic-feed-links');

        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        $html5 = array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        );
        add_theme_support( 'html5', apply_filters( 'html5_support', $html5 ) );

        /**
         * Enable support for title-tag.
         */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         * @var array
         */
        $post_formats = array(
            'aside',
            'image',
            'gallery',
            'link',
            'quote',
            'status',
            'video',
            'audio',
            'chat'
        );
        add_theme_support('post-formats', apply_filters( 'post_formats_support', $post_formats ) );

        /**
         * Custom header value array
         * @var array
         */
        $defaults = array(
            'default-image'          => '',
            'width'                  => 1140,
            'height'                 => 400,
            'flex-height'            => false,
            'flex-width'             => false,
            'uploads'                => true,
            'random-default'         => false,
            'header-text'            => true,
            'default-text-color'     => '',
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        );
        add_theme_support( 'custom-header', apply_filters( 'custom_header_support', $defaults ) );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        $locations = array(
            'main-menu' => __( 'Main Menu', 'ItalyStrap' ) 
        );
        register_nav_menus( apply_filters( 'register_nav_menu', $locations ) );

        /**
         *  Size for default template image
         */
        require locate_template('lib/image_size.php');
    }

    add_action('after_setup_theme', 'ItalyStrap_theme_setup');

endif;


// Config file
/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 848px is the default ItalyStrap container width.
 */
if ( !isset($content_width) ) $content_width = apply_filters( 'content_width', 848 );