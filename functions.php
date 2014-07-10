<?php
require_once locate_template('/lib/globals.php');				// Globals variables
require_once locate_template('/lib/cleanup.php');        		// Cleanup Headers
require_once locate_template('/lib/script.php');        		// All Js and CSS script
require_once locate_template('/lib/breadcrumb.php');      		// Breadcrumb
require_once locate_template('/lib/gallery.php');				// New gallery
require_once locate_template('/lib/relative-urls.php');			//
require_once locate_template('/lib/widget.php');				// Widget
//require_once locate_template('/lib/wp_bootstrap_gallery.php');	// Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery
require_once locate_template('/lib/custom-post-type.php');		//
require_once locate_template('/lib/wp-h5bp-htaccess.php');		// https://github.com/roots/wp-h5bp-htaccess
require_once locate_template('/lib/custom_meta_box.php');		// Custom Meta Box
require_once locate_template('/lib/sidebar.php');				// Sidebar
require_once locate_template('/lib/pagination.php');			// Pagination
require_once locate_template('/lib/related_post.php');			// Related Post
require_once locate_template('/lib/custom_fields.php');			// Custom fields
require_once locate_template('/lib/users_meta.php');			// Users meta
require_once locate_template('/lib/custom_excerpt.php');		// Custom excerpt_length and more
require_once locate_template('/lib/schema.php');				// Function for Schema.org and OG
require_once locate_template('/lib/custom_taxonomy.php');		// Custom taxonomy
require_once locate_template('/lib/images.php');				// Custom function for images
require_once locate_template('/lib/comment_reply.php');         // new_get_cancel_comment_reply_link
require_once locate_template('/lib/comments.php');			    // Walker comments
require_once locate_template('/lib/tag_cloud.php');             // New style for tag cloud
//require_once locate_template('/lib/css-above-the-fold.php');	//
require_once locate_template('/lib/debug.php');                 // Function for debugging
require_once locate_template('/lib/password_protection.php');	// Function for Post/page password protection Bootstrap style
/*
 * Setup Theme Functions
 */
if (!function_exists('ItalyStrap_theme_setup')):
    function ItalyStrap_theme_setup() {

        //load_theme_textdomain('ItalyStrap', get_template_directory() . '/lang');

        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ));
		register_nav_menus(array('main-menu' => __('Main Menu', 'ItalyStrap')));
        // load custom walker menu class file
        require 'lib/wp_bootstrap_navwalker.php';
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
 * Default: 1140px is the default Bootstrap container width.
 */
if ( !isset($content_width) ) { $content_width = 1140; }
?>