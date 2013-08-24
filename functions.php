<?php
require_once locate_template('/lib/cleanup.php');        		//Cleanup
require_once locate_template('/lib/breadcrumb.php');      		//Breadcrumb
require_once locate_template('/lib/widget.php');
require_once locate_template('/lib/wp_bootstrap_gallery.php');	//Register Custom Gallery:https://github.com/twittem/wp-bootstrap-gallery
require_once locate_template('/lib/custom-post-type.php');

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
    }
endif;
add_action('after_setup_theme', 'ItalyStrap_theme_setup');


//definisco una variabile globale per la url del template e dell'immagine di default
$path = get_template_directory_uri();
$defaultimage = $path . '/img/ItalyStrap.jpg';

function italystrap_thumb_url()
{
	global $defaultimage;
	if ( has_post_thumbnail() ) {
	$post_thumbnail_id = get_post_thumbnail_id();
	$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	echo $image_attributes[0]; 
	
	} else echo $defaultimage;
}

function italystrap_logo()
{
	global $defaultimage;
	return $defaultimage;
}

/* Aggiungi la favicon al tuo Blog
 * by Roberto Iacono di robertoiacono.it
 */
function ri_wp_favicon()
{
	global $path;
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $path . '/img/favicon.ico" />';
}
add_action('wp_head', 'ri_wp_favicon');

//Carico gli stili CSS
function italystrap_add_style()
	{
		global $path;
		wp_enqueue_style( 'bootstrap',  $path . '/css/bootstrap.min.css', null, null);
		wp_enqueue_style( 'style',  $path . '/style.css', null, null);
	}
if (!is_admin()) 
	{
		add_action( 'wp_enqueue_scripts', 'italystrap_add_style' ); 
	}

//Carico jquery da google api cdn
function italystrap_add_jquery_googlecdn() 
	{
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, true);
		wp_enqueue_script('jquery');
	}
if (!is_admin())
	{
		add_action('init', 'italystrap_add_jquery_googlecdn');
	}

//Carico gli script JS
function italystrap_add_javascripts() 
	{
		global $path;
		wp_enqueue_script( 'bootstrap', $path . '/js/bootstrap.min.js', null, null,  true );
		wp_enqueue_script('socialite', $path . '/js/socialite.js', null, null, true);
	}
if (!is_admin()) 
	{
		add_action( 'wp_print_scripts', 'italystrap_add_javascripts' ); 
	}
	
	
//http://www.emoticode.net/php/add-async-and-defer-to-script-on-wordpress.html
// function defer_parsing_of_js ( $url ) {
	// if ( FALSE === strpos( $url, '.js' ) ) return $url;
	// if ( strpos( $url, 'jquery.js' ) ) return $url;
	// return "$url' async defer";
// }
	//add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

//Registro l'area widget classica nella sidebar
if (function_exists('register_sidebar'))
{
	register_sidebar( array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Box 1', 'ItalyStrap' ),
		'id' => 'footer-box-1',
		'description' => __( 'Footer box 1 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="span3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 2', 'ItalyStrap' ),
		'id' => 'footer-box-2',
		'description' => __( 'Footer box 2 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="span3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 3', 'ItalyStrap' ),
		'id' => 'footer-box-3',
		'description' => __( 'Footer box 3 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="span3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Box 4', 'ItalyStrap' ),
		'id' => 'footer-box-4',
		'description' => __( 'Footer box 4 widget area (Usa solo un widget)', 'ItalyStrap' ),
		'before_widget' => '<div class="span3">',
		'after_widget'  => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

//Definisco la lunghezza massima excerpt
function custom_excerpt_length( $length ) {
	if ( is_home() || is_front_page() ){
	return 30;}
	else{
	return 50;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 20 );

function new_excerpt_more( $more ) {
	if ( is_home() || is_front_page() ){
	return '';}
	else{
	return ' <a href="'. get_permalink() . '">... Continua a leggere</a>';
	}
}
add_filter('excerpt_more', 'new_excerpt_more');

/*
=================================================================*/
add_image_size( 'slide', 1170, 468, true);
add_image_size( 'article-thumb', 760, 380, true);
add_image_size( 'article-thumb-index', 260, 130, true);
add_image_size( 'full-width', 1170, 585, true);



add_action('wp_insert_post', 'italystrap_set_default_custom_fields');
 
function italystrap_set_default_custom_fields($post_id)
{
 if (isset($_GET['post_type']) && $_GET['post_type'] == 'prodotti' ) {
 
        add_post_meta($post_id, 'headline', '', true);
        add_post_meta($post_id, 'call_to_action', '', true);
 
    }
    return true;
}
//http://yoast.com/user-contact-fields-wordpress/
function italystrap_add_social_contactmethod( $contactmethods ) {
  // Add Avatar
  if ( !isset( $contactmethods['avatar'] ) )
	$contactmethods['avatar'] = 'Url avatar' ; 
  // Add Skype
  if ( !isset( $contactmethods['skype'] ) )
	$contactmethods['skype'] = 'Skype' ; 
  // Add Twitter
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';
	// Add Google Profiles
  if ( !isset( $contactmethods['google_profile'] ) )
	$contactmethods['google_profile'] = 'Google Profile URL';
	// Add Google Page
  if ( !isset( $contactmethods['google_page'] ) )
	$contactmethods['google_page'] = 'Google Page URL';
	// Add Facebook Profile
  if ( !isset( $contactmethods['fb_profile'] ) )
	$contactmethods['fb_profile'] = 'Facebook Profile URL';
	// Add Facebook Page
  if ( !isset( $contactmethods['fb_page'] ) )
	$contactmethods['fb_page'] = 'Facebook Page URL';
	// Add LinkedIn
  if ( !isset( $contactmethods['linkedIn'] ) )
	$contactmethods['linkedIn'] = 'LinkedIn';
	// Add Pinterest
  if ( !isset( $contactmethods['pinterest'] ) )
	$contactmethods['pinterest'] = 'Pinterest';
	// Add Instagram
  //if ( !isset( $contactmethods['instagram'] ) )
	//$contactmethods['instagram'] = 'Instagram';

  // Remove Yahoo IM
  if ( isset( $contactmethods['yim'] ) )
    unset( $contactmethods['yim'] );
  // Remove jabber/Google Talk
  if ( isset( $contactmethods['jabber'] ) )	
	unset( $contactmethods['jabber'] );
  // Remove AIM
  if ( isset( $contactmethods['aim'] ) )		
	unset( $contactmethods['aim'] );

  return $contactmethods;
}
add_filter( 'user_contactmethods', 'italystrap_add_social_contactmethod', 10, 1 );

/*Defined at: wp-includes/comment-template.php, line 1153*/
function new_get_cancel_comment_reply_link($text = '') {
	if ( empty($text) )
		$text = __('Click here to cancel reply.');

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	return apply_filters('new_cancel_comment_reply_link', '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . ' class="btn">' . $text . '</a>', $link, $text);
}
function new_cancel_comment_reply_link($text = '') {
	echo new_get_cancel_comment_reply_link($text);
}
/*Fine modifica wp-includes/comment-template.php*/


//Funzione per http://schema.org/Article: wordCount - timeRequired
function italystrap_ttr_wc(){

	ob_start();
    the_content();
    $content = ob_get_clean();
    $word_count = sizeof(explode(" ", $content));

	$words_per_minute = 150;
	
	// Get Estimated time
	$minutes = floor( $word_count / $words_per_minute);
	$seconds = floor( ($word_count / ($words_per_minute / 60) ) - ( $minutes * 60 ) );
	
	// If less than a minute
	if( $minutes < 1 ) {
		$estimated_time = 'PT1M';
	}
	
	// If more than a minute
	if( $minutes >= 1 ) {
		if( $seconds > 0 ) {
			$estimated_time = 'PT' . $minutes . 'M' . $seconds . 'S';
		} else {
			$estimated_time = 'PT' . $minutes.__( 'M', 'rc_prds' );
		}
	}
	
	$ttr_wc = '<meta  itemprop="wordCount" content="' . $word_count . '"/><br/><meta  itemprop="timeRequired" content="' . $estimated_time . '"/>';
	return $ttr_wc;
}


// function create_my_taxonomies() {

// register_taxonomy('NOMETASSONOMIA', 'page', array(
													// 'hierarchical' => false, 
													// 'label' => 'NOMETASSONOMIA',
													// 'query_var' => true,
													// 'rewrite' => true
													// ));
// }

// add_action('init', 'create_my_taxonomies', 0);

//funzione per estrapolare le url da gravatar
function estraiUrlsGravatar($url)  
{
	$url_pulito = substr($url,17,-56);
	return $url_pulito; 
}


//http://www.lanexa.net/2012/09/add-twitter-bootstrap-pagination-to-your-wordpress-theme/
function bootstrap_pagination($pages = '', $range = 2)
{
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
	global $wp_query;
	$pages = $wp_query->max_num_pages;
	if(!$pages)
	{
	$pages = 1;
	}
	}

	if(1 != $pages)
	{
	echo "<div class='pagination pagination-centered'><ul>";
	if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
	if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

	for ($i=1; $i <= $pages; $i++)
	{
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	{
	echo ($paged == $i)? "<li class='active'><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
	}
	}

	if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
	if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
	echo "</ul></div>\n";
}
}
//Funzione per mostrare una descrition in open graph e twitter card
function italystrap_open_graph_desc(){
	global $post;
	if ( function_exists('aioseop_load_modules')) {
		//Codice per All in One Seo pack
		$post_aioseo_desc = get_post_meta($post->ID, '_aioseop_description', true);
		if($post_aioseo_desc){
		echo stripcslashes($post_aioseo_desc);
		}}
}

?>