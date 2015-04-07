<?php
/**
 * ItalyStrap functions and definitions
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

/**
 * Define ITALYSTRAP_THEME constant for internal use
 */
define('ITALYSTRAP_THEME', true);

/**
 * TGM class for required plugin
 */
if ( is_admin() )
	require_once locate_template('/includes/class-tgm-plugin-required.php');

/**
 * Mobile Detect CLass
 * Load only if class not exist
 */
if ( !class_exists( 'Mobile_Detect' ) ){

	require_once locate_template('/includes/Mobile_Detect.php');
	$detect = new Mobile_Detect;

}

/*********************************************************************
 * Start Admins functionality, don't touch that, extend class instead
 * 
 *********************************************************************/

/**
 * Admin Options Theme
 */
require_once locate_template('/admin/ItalyStrapOptionTheme.php');

/**
 * Admin functionality
 */
require_once locate_template('/admin/ItalyStrapAdmin.php');

/*******************************************************************
 * Start Core functionality, don't touch that, extend class instead
 * 
 *******************************************************************/

/**
 * Add field for adding glyphicon in menu
 */
require_once locate_template('/core/ItalyStrap_custom_menu.php');
new ItalyStrap_custom_menu();

/**
 * Add new Class for Breadcrumbs
 */
require_once locate_template('/core/ItalyStrapBreadcrumbs.php');


require_once locate_template('/core/analytics.php');



/*************************************************************************
 * Start custom functionality, you can touch that, please use child theme
 * 
 *************************************************************************/

/**
 * Function for init load.
 * In this file there are after_setup_theme and $content_width
 */
require_once locate_template('/lib/init.php');

/**
 * Activation options, added pointer for theme instructions.
 */
require_once locate_template('/lib/activation.php');

/**
 * Globals variables for internal use.
 */
require_once locate_template('/lib/globals.php');

/**
 * Cleanup Headers.
 */
require_once locate_template('/lib/cleanup.php');

/**
 * Load all Js and CSS script in theme.
 */
require_once locate_template('/lib/script.php');

/**
 * Breadcrumb.
 * @deprecated 2.0.0
 * @deprecated Use new ItalyStrapBreadcrumbs( $defaults );
 * @see ItalyStrapBreadcrumbs( $defaults );
 */
require_once locate_template('/lib/breadcrumb.php');

/**
 * Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery.
 */
//require_once locate_template('/lib/wp_bootstrap_gallery.php');

/**
 * New gallery.
 */
require_once locate_template('/lib/gallery.php');

/**
 *
 */
require_once locate_template('/lib/relative-urls.php');

/**
 * Custom Widget.
 */
// require_once locate_template('/lib/widget.php');

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
 * Function for Post/page password protection Bootstrap style
 */
require_once locate_template('/lib/password_protection.php');

/**
 * Custom shortcode
 */
require_once locate_template('/lib/custom_shortcode.php');

/**
 * Some function for make wordpress more secure
 */
require_once locate_template('/lib/security.php');

/**
 * Functions for debugging porpuse
 */
require_once locate_template('/lib/debug.php');


/**
 * Echo the ItalyStrap theme version (parent or child if exist)
 * Used in footer
 * @return string
 */
function italystrap_version(){

	$ver = wp_get_theme();
	echo $ver->display('Version');

}

/**
 * The problem:
 * @link https://developer.wordpress.org/reference/functions/capital_p_dangit/
 *       Forever eliminate "Wordpress" from the planet
 *       (or at least the little bit we can influence).
 * @link http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit
 */
remove_filter( 'the_title', 'capital_P_dangit', 11 );
remove_filter( 'the_content', 'capital_P_dangit', 11 );
remove_filter( 'comment_text', 'capital_P_dangit', 31 );

/**
 * Forever eliminate "Wordpress" from the planet
 * (or at least the little bit we can influence).
 *
 * @see capital_P_dangit( $text );
 * @link http://codex.wordpress.org/Function_Reference/capital_P_dangit
 * @param string $text sanitize WordPress word
 * @return string Return string sanitized
 */
function ItaliStrap_capital_P_dangit($text){

	return str_replace(
		array( ' Wordpress', '&#8216;Wordpress', 'Wordpress', '>Wordpress', '(Wordpress', ' wordpress', '&#8216;wordpress', 'wordpress', '>wordpress', '(wordpress' ),
			array( ' WordPress', '&#8216;WordPress', 'WordPress', '>WordPress', '(WordPress', ' WordPress', '&#8216;WordPress', 'WordPress', '>WordPress', '(WordPress' ),
				$text );
}

/**
 * Remove p lowercase in content and title
 *
 * @link https://wordpress.org/support/topic/modifying-title-before-saving-custom-post?replies=2 The idea from
 * @see wp_insert_post_data filter
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_insert_post_data
 * 
 * @param array $data    Post data array
 * @param array $postarr Raw post data
 * @return P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_content( $data , $postarr ){

	$data['post_title'] = ItaliStrap_capital_P_dangit($data['post_title']);
	$data['post_content'] = ItaliStrap_capital_P_dangit($data['post_content']);

	return $data;
}

add_filter( 'wp_insert_post_data' , 'ItalyStrap_P_dangit_sanitize_content' , '99', 2 );

/**
 * Remove p lowercase in comments contents when publish
 * @see preprocess_comment filter
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/preprocess_comment
 * 
 * @param array $commentdata Comment data array
 * @return array P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_comments( $commentdata ) {

	$commentdata['comment_content'] = ItaliStrap_capital_P_dangit( $commentdata['comment_content'] );

	return $commentdata;
}
add_filter( 'preprocess_comment' , 'ItalyStrap_P_dangit_sanitize_comments' );


/**
 * Remove p lowercase in comments contents when updating/editing
 * @see comment_save_pre filter
 * @link https://developer.wordpress.org/reference/hooks/comment_save_pre/
 * 
 * @param string $comment_content Comment content
 * @return string P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_comments_update($comment_content){

	$comment_content = ItaliStrap_capital_P_dangit( $comment_content );

	return $comment_content;
}
add_filter( 'comment_save_pre', 'ItalyStrap_P_dangit_sanitize_comments_update', 10 , 3 );