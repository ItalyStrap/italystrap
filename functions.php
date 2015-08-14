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
define( 'ITALYSTRAP_THEME', true );

/**
 * Define parent path directory
 */
define( 'ITALYSTRAP_PARENT_PATH', get_template_directory_uri() );
$path = ITALYSTRAP_PARENT_PATH; //Var deprecated from 3.0.6

/**
 * Define child path directory if is active child theme
 */
if ( is_child_theme() ) {
	define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );
	$pathchild = ITALYSTRAP_CHILD_PATH;
}else
	$pathchild = '';

/**
 * Define Bog Name constant
 */
if ( !defined( 'GET_BLOGINFO_NAME' ) )
    define( 'GET_BLOGINFO_NAME', get_option('blogname') );

/**
 * Define Blog Description Constant
 */
if ( !defined( 'GET_BLOGINFO_DESCRIPTION' ) )
    define( 'GET_BLOGINFO_DESCRIPTION', get_option('blogdescription') );

/**
 * Define HOME_URL
 */
if ( !defined( 'HOME_URL' ) )
    define( 'HOME_URL', get_home_url( null, '/') );

/**
 * Define theme otpion array
 * @var array
 */
$italystrap_options = get_option( 'italystrap_theme_settings' );

/**
 * The customiser optionr of ItalyStrap
 * @var array
 */
$italystrap_theme_mods = get_theme_mods();

/*********************************************************************
 * Required external class
 * 
 *********************************************************************/

/**
 * TGM class for required plugin
 */
if ( is_admin() )
	require locate_template('/includes/class-tgm-plugin-required.php');

/**
 * Mobile Detect CLass
 * Load only if class not exist
 */
if ( !class_exists( 'Mobile_Detect' ) ){

	require locate_template('/includes/Mobile_Detect.php');
	$detect = new Mobile_Detect;

}

/*********************************************************************
 * Start Admins functionality, don't touch that, extend the class instead
 * 
 *********************************************************************/

/**
 * Admin Options Theme
 */
require locate_template('/admin/ItalyStrapOptionTheme.php');

/**
 * Admin functionality
 */
require locate_template('/admin/ItalyStrapAdmin.php');

/**
 * Admin customizer
 */
require locate_template('/admin/class-italystrap-theme-customizer.php');

/*******************************************************************
 * Start Core functionality, don't touch that, extend class instead
 * 
 *******************************************************************/

/**
 * Add field for adding glyphicon in menu
 */
require locate_template('/core/ItalyStrap_custom_menu.php');
    new ItalyStrap_custom_menu();

/**
 * Add new Class for Breadcrumbs
 */
require locate_template('/core/ItalyStrapBreadcrumbs.php');

/**
 * 
 */
require locate_template('/core/analytics.php');

/**
 * Custom function for images.
 */
require locate_template('/core/images.php');

/**
 * Class for template functions
 * Depend of images.php
 */
require locate_template('/core/class_italystrap_template_functions.php');
	// $italystrap_template = new ItalyStrap_template_functions;

/**
 * Class for Excerpt
 */
require locate_template('/core/class_italystrap_excerpt.php');

/**
 * Sidebar class.
 */
require locate_template('/core/class-italystrap-sidebars.php');
/**
 * If function exist init
 */
if ( function_exists( 'register_widget' ) )
	$italystrap_sidebars = new ItalyStrap_Sidebars;

/*************************************************************************
 * Start custom functionality, you can touch that, please use child theme
 * 
 *************************************************************************/

/**
 * Activation options, added pointer for theme instructions.
 */
require locate_template('/lib/pointer.php');

/**
 * Cleanup Headers.
 */
require locate_template('/lib/cleanup.php');

/**
 * Load all Js and CSS script in theme.
 */
require locate_template('/lib/script.php');

/**
 * Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery.
 */
//require locate_template('/lib/wp_bootstrap_gallery.php');

/**
 * New gallery.
 */
require locate_template('/lib/gallery.php');

/**
 *
 */
require locate_template('/lib/relative-urls.php');

/**
 * Custom Widget.
 */
// require locate_template('/lib/widget.php');

/**
 * Custom Post Type.
 */
require locate_template('/lib/custom-post-type.php');

/**
 * https://github.com/roots/wp-h5bp-htaccess.
 */
require locate_template('/lib/wp-h5bp-htaccess.php');

/**
 * Custom Meta Box.
 */
require locate_template('/lib/custom_meta_box.php');

/**
 * Pagination.
 */
require locate_template('/lib/pagination.php');

/**
 * Related Post.
 */
require locate_template('/lib/related_post.php');

/**
 * Custom fields.
 */
require locate_template('/lib/custom_fields.php');

/**
 * Users meta.
 */
require locate_template('/lib/users_meta.php');

/**
 * Custom excerpt_length and more.
 */
require locate_template('/lib/custom_excerpt.php');

/**
 * Function for Schema.org and OG.
 */
require locate_template('/lib/schema.php');

/**
 * Custom taxonomy.
 */
require locate_template('/lib/custom_taxonomy.php');

/**
 * new_get_cancel_comment_reply_link
 */
require locate_template('/lib/comment_reply.php');

/**
 * Walker comments
 */
require locate_template('/lib/comments.php');

/**
 * New style for tag cloud
 */
require locate_template('/lib/tag_cloud.php');

/**
 * 
 */
//require locate_template('/lib/css-above-the-fold.php');

/**
 * Function for Post/page password protection Bootstrap style
 */
require locate_template('/lib/password_protection.php');

/**
 * Custom shortcode
 */
require locate_template('/lib/custom_shortcode.php');

/**
 * Some function for make wordpress more secure
 */
require locate_template('/lib/security.php');

/**
 * Functions for debugging porpuse
 */
require locate_template('/lib/debug.php');

/**
 * load custom walker menu class file
 */
require locate_template('lib/wp_bootstrap_navwalker.php');

/*********************************************************************
 * Deprecated files and functions
 *********************************************************************/

/**
 * Breadcrumb.
 * @deprecated 2.0.0
 * @deprecated Use new ItalyStrapBreadcrumbs( $defaults );
 * @see ItalyStrapBreadcrumbs( $defaults );
 */
// require locate_template('/deprecated/breadcrumb.php');

/**
 * Sidebar.
 * @deprecated 3.0.6
 */
// require locate_template('/deprecated/sidebar.php');

/**
 * Globals variables for internal use.
 * @deprecated 3.0.6
 */
// require locate_template('/deprecated/globals.php');

/**
 * Function for init load.
 * In this file there are after_setup_theme and $content_width
 * @deprecated 3.0.6
 */
// require locate_template('/lib/init.php');

/*********************************************************************
 * Class init for Theme
 *********************************************************************/

/**
 * 
 */
class ItaltStrap_Init_Theme{
	
	function __construct(){
		
		add_action('after_setup_theme', array( $this, 'theme_setup') );

	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
    public function theme_setup() {
        
        /*
         * Make theme available for translation.
         */
        load_theme_textdomain( 'ItalyStrap', get_template_directory() . '/lang' );

        /**
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support
         */

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
        $custom_header = array(
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
        	);
        add_theme_support( 'custom-header', apply_filters( 'custom_header_support', $custom_header ) );

        /**
         * Custom background support
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
		 * @see class-italystrap-theme-customizer.php
         */
		$custom_background = array(
			'wp-head-callback' => 'italystrap_custom_background_cb'
		);
		add_theme_support( 'custom-background', apply_filters( 'custom_background_support', $custom_background ) );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        $nav_menus_locations = array(
            'main-menu' => __( 'Main Menu', 'ItalyStrap' ) 
        );
        register_nav_menus( apply_filters( 'register_nav_menu', $nav_menus_locations ) );

        /**
         *  Size for default template image
         */
        require locate_template('lib/image_size.php');
    }

}

new ItaltStrap_Init_Theme;






/*********************************************************************
 * Standard Functions
 *********************************************************************/

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide,
 * set $content_width = 620; so images and videos will not overflow.
 * Default: 848px is the default ItalyStrap container width.
 */
if ( !isset($content_width) ) $content_width = apply_filters( 'content_width', 848 );

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

// function prova(){

// 	echo '<div style="background-color:yellow;width:100%;height:30px;"></div>';

// }
// function prova(){

//                     if ( class_exists('ItalyStrapBreadcrumbs') ) {

//                         $defaults = array(
//                             'home'    =>  '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>'
//                         );

//                         new ItalyStrapBreadcrumbs( $defaults );
                    
//                     }

// }
// add_action( 'before_loop', 'prova' );

/**
 * @link https://codex.wordpress.org/Function_Reference/get_search_form
 * @return string Return the search form
 */
function italystrap_get_search_form(){

	$get_search_query = ( is_search() ) ? get_search_query() : '' ;

	$form = '<div itemscope itemtype="http://schema.org/WebSite"><meta itemprop="url" content="' . esc_attr( HOME_URL ) . '"/><form class="navbar-form navbar-right" role="search" method="get" action="' . esc_attr( HOME_URL ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction"><meta itemprop="target" content="' . esc_attr( HOME_URL ) . '?s={s}"/><div class="input-group input-group-sm"><input type="search" size="16" placeholder="' . __('Search now', 'ItalyStrap') . '" value="' . $get_search_query . '" name="s" class="form-control" itemprop="query-input"><span class="input-group-btn"><button type="submit" class="btn btn-default" value="' . __('Search', 'ItalyStrap') . '"><i class="glyphicon glyphicon-search"></i></button></span></div></form></div>';

	return $form;

}


add_filter( 'wp_nav_menu', 'italystrap_print_search_form_in_menu', 10, 2 );

/**
 * Funzione per aggiungere il form di ricerca nel menù di navigazione
 * Per funzionare aggiungere il parametro search con valore true all'array passato a wp_nav_menu()
 * 
 * @todo Aggiungere opzione per stampare il form prima o dopo wp_nav_menu()
 * @param  string $nav_menu The nav menu output
 * @param  object $args     wp_nav_menu arguments in object
 * @return string           The nav menu output
 */
function italystrap_print_search_form_in_menu( $nav_menu, $args ){

	if ( !isset( $args->search ) )
		return $nav_menu;
	// var_dump($args->search);
	return str_replace( '</div>', italystrap_get_search_form() . '</div>', $nav_menu);
}