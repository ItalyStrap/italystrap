<?php
/**
 * ItalyStrap functions and definitions
 *
 * @package ItalyStrap
 */

/**
 * Activation options.
 */
require_once locate_template('/lib/activation.php');

/**
 * Globals variables.
 */
require_once locate_template('/lib/globals.php');

/**
 * Cleanup Headers.
 */
require_once locate_template('/lib/cleanup.php');

/**
 * All Js and CSS script.
 */
require_once locate_template('/lib/script.php');

/**
 * Breadcrumb.
 */
require_once locate_template('/lib/breadcrumb.php');

/**
 * New gallery.
 */
require_once locate_template('/lib/gallery.php');

/**
 *
 */
require_once locate_template('/lib/relative-urls.php');

/**
 * Widget.
 */
require_once locate_template('/lib/widget.php');

/**
 * Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery.
 */
//require_once locate_template('/lib/wp_bootstrap_gallery.php');

/**
 * Custom Post Type.
 */
require_once locate_template('/lib/custom-post-type.php');

/**
 * https://github.com/roots/wp-h5bp-htaccess.
 */
require_once locate_template('/lib/wp-h5bp-htaccess.php');

/**
 * Custom Meta Box.
 */
require_once locate_template('/lib/custom_meta_box.php');

/**
 * Sidebar.
 */
require_once locate_template('/lib/sidebar.php');

/**
 * Pagination.
 */
require_once locate_template('/lib/pagination.php');

/**
 * Related Post.
 */
require_once locate_template('/lib/related_post.php');

/**
 * Custom fields.
 */
require_once locate_template('/lib/custom_fields.php');

/**
 * Users meta.
 */
require_once locate_template('/lib/users_meta.php');

/**
 * Custom excerpt_length and more.
 */
require_once locate_template('/lib/custom_excerpt.php');

/**
 * Function for Schema.org and OG.
 */
require_once locate_template('/lib/schema.php');

/**
 * Custom taxonomy.
 */
require_once locate_template('/lib/custom_taxonomy.php');

/**
 * Custom function for images.
 */
require_once locate_template('/lib/images.php');

/**
 * new_get_cancel_comment_reply_link
 */
require_once locate_template('/lib/comment_reply.php');

/**
 * Walker comments
 */
require_once locate_template('/lib/comments.php');

/**
 * New style for tag cloud
 */
require_once locate_template('/lib/tag_cloud.php');

/**
 * 
 */
//require_once locate_template('/lib/css-above-the-fold.php');

/**
 * Function for debugging
 */
require_once locate_template('/lib/debug.php');

/**
 * Function for Post/page password protection Bootstrap style
 */
require_once locate_template('/lib/password_protection.php');

/**
 * File for install required plugin
 */
require_once locate_template('/lib/class-tgm-plugin-activation.php');

/**
 * File for install required plugin
 */
require_once locate_template('/lib/class-tgm-plugin-required.php');

/**
 * Custom shortcode
 */
require_once locate_template('/lib/custom_shortcode.php');

/**
 * Some function for make wordpress more secure
 */
require_once locate_template('/lib/security.php');


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
         * Translations can be filed in the /lang/ directory.
         * If you're building a theme based on ItalyStrap, use a find and replace
         * to change 'ItalyStrap' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'ItalyStrap', get_template_directory() . '/lang' );

        /**
         * Add default posts and comments RSS feed links to head.
         */
        add_theme_support('automatic-feed-links');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ) );

        /**
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ));

        /**
         * This theme uses wp_nav_menu() in one location.
         */
		register_nav_menus( array( 'main-menu' => __( 'Main Menu', 'ItalyStrap' ) ) );

        /**
         * load custom walker menu class file
         */
        require 'lib/wp_bootstrap_navwalker.php';

        /**
         *  Size for default template image
         */
        require_once locate_template('/lib/image_size.php');
    }

endif;

add_action('after_setup_theme', 'ItalyStrap_theme_setup');

//Show version theme in footer
function italystrap_version(){

	$ver = wp_get_theme();
	echo $ver->display('Version');
    
}

// Config file
/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 848px is the default Bootstrap container width.
 */
if ( !isset($content_width) ) { $content_width = 848; }