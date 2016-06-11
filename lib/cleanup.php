<?php
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
function roots_head_cleanup() {
	// Originally from http://wpengineer.com/1438/wordpress-header/
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

	add_filter( 'use_default_gallery_style', '__return_null' );

	// Define if SEO Yoast or AIOSP classes exists
	if ( ( class_exists( 'WPSEO_Frontend' ) ) || ( class_exists( 'All_in_One_SEO_Pack' ) ) ) {
		$italystrapClassexists = 1;
	} else {
		$italystrapClassexists = null;
	}

	if ( ! $italystrapClassexists ) {
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'wp_head', 'italystrap_rel_canonical' );
		add_action( 'wp_head', 'italystrap_rel_next_prev' );
	}
}

function italystrap_rel_canonical() {

	global $paged;
	// The belove commentes code is an experiment
	// if ( is_single() && $paged ) {
	// $link = get_permalink();
	// }else{
	// $link = get_pagenum_link( $paged );
	// }
	$link = get_pagenum_link( $paged );
	echo "\n<link rel=\"canonical\" href=\"$link\">\n";
}

/**
 * If you would remove Canonical Link Added By Yoast WordPress SEO Plugin uncommented belove code
 *
 * @link http://stackoverflow.com/questions/10529409/removing-rel-canonical-added-by-yoast-seo-plugin
 */
// add_filter( 'wpseo_canonical', '__return_false' );
/**
 * Add rel next and prev in head tag for pagination
 *
 * @link http://wordpress.stackexchange.com/questions/36800/adding-rel-next-rel-prev-for-paginated-archives#comment45820_36800
 * @link http://stackoverflow.com/questions/11086315/how-to-get-number-of-results-from-query-posts
 * Modify for visualize in page template blog
 * @link http://www.giorgiotave.it/forum/title-description-e-struttura/216762-pagination-rel-next-e-rel-prev-e-canonical-tag-ce-conflitto.html
 * @since 1.9.2
 */
function italystrap_rel_next_prev() {

	global $paged, $posts_per_page;

	$allsearch = new WP_Query( 'showposts=-1' );
	$count = $allsearch->post_count;

	wp_reset_query();
	wp_reset_postdata();

	$max_page = $count / $posts_per_page + 1;
	$max_page = intval( $max_page );

	if ( get_previous_posts_link() ) { ?>
        <link rel="prev" href="<?php echo get_pagenum_link( $paged - 1 ); ?>" />
<?php }

	if ( get_next_posts_link() ) { ?>
        <link rel="next" href="<?php echo get_pagenum_link( $paged + 1 ); ?>" />
<?php

	}
	// If is page template blog show rel="next"
	if ( is_page( 'blog' ) && $paged < $max_page ) { ?>
        <link rel="next" href="<?php echo get_pagenum_link( $paged + 1 ); ?>" />
<?php

	} // End is page template blog

	global $multipage , $page, $pages;
	if ( is_single() && $multipage ) {
		// If is post paginates with <!--nextpage--> quicktag
		$get_permalink = get_permalink();
		if ( $page == 1 ) { // If page is 1 echo only rel="next" ?>
		  <link rel="next" href="<?php echo $get_permalink . '/' . ($page + 1); ?>" />
	<?php
		}

		$pagTotali = count( $pages ); // Number of total page pagination in post
		if ( $page == 2 ) {
			$prevpage = null; // If page number is 2 $prevpage echo nothing
		} else {
			$prevpage = '/' . ($page -1);
		}
		if ( $page > 1 && $page < $pagTotali ) { // If page is > than 1 and then $pagTotali ?>
		  <link rel="prev" href="<?php echo $get_permalink . $prevpage; ?>" />
		  <link rel="next" href="<?php echo $get_permalink . '/' . ($page + 1); ?>" />
	<?php
		}

		if ( $page == $pagTotali ) { // If page is == $pagTotali echo only rel="prev" ?>
		  <link rel="prev" href="<?php echo $get_permalink . $prevpage; ?>" />

	<?php
		}
	} // End is_single() && $multipage pagination
}

add_action( 'init', 'roots_head_cleanup' );

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter( 'the_generator', '__return_false' );

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
 *
 * @todo  Da capire perché esiste questa funzione
 *        Disattivata nella versione 3.1 perchè devo capirne il senso
 *        Forse hanno aperto una qualche issue in merito
 */
function roots_language_attributes() {
	_deprecated_function( __FUNCTION__, '3.1' );
	$attributes = array();
	$output = '';

	if ( function_exists( 'is_rtl' ) ) {
		if ( is_rtl() == 'rtl' ) {
			$attributes[] = 'dir="rtl"';
		}
	}

	$lang = get_bloginfo( 'language' );

	if ( $lang && $lang !== 'en-US' ) {
		$attributes[] = "lang=\"$lang\"";
	} else {
		$attributes[] = 'lang="en"';
	}

	$output = implode( ' ', $attributes );
	$output = apply_filters( 'roots_language_attributes', $output );

	return $output;
}
// add_filter('language_attributes', 'roots_language_attributes');
/**
 * Manage output of wp_title()
 *
 * @deprecated 3.1
 */
function roots_wp_title( $title ) {
	_deprecated_function( __FUNCTION__, '3.1' );
	if ( is_feed() ) {
		return $title;
	}

	$title .= ' ' . GET_BLOGINFO_NAME;

	return $title;
}
// add_filter('wp_title', 'roots_wp_title', 10);
/**
 * Clean up output of stylesheet <link> tags
 */
function roots_clean_style_tag( $input ) {
	preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );
	// Only display media if it is meaningful
	$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter( 'style_loader_tag', 'roots_clean_style_tag' );

/**
 * Add and remove body_class() classes
 */
function roots_body_class( $classes ) {
	// Add post/page slug
	if ( is_single() || is_page() && ! is_front_page() ) {
		$classes[] = basename( get_permalink() );
	}

	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option( 'page_on_front' );
	$remove_classes = array(
	'page-template-default',
	$home_id_class,
	);
	$classes = array_diff( $classes, $remove_classes );

	return $classes;
}
add_filter( 'body_class', 'roots_body_class' );

/**
 * Wrap embedded media as suggested by Readability
 * Add code ti Oembed media
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 * Rootstheme function
 * Renamed and modify for new bootstrap class for video embed
 */
function italystrap_embed_wrap( $html, $url, $attr = '', $post_ID = '' ) {

	if ( strpos( $html, 'class="twitter-tweet"' ) ) {
		return $html; } else {
		return '<div class="entry-content-asset embed-responsive embed-responsive-16by9">' . str_replace( '<iframe' , '<iframe class="embed-responsive-item"', $html ) . '</div>'; }

}
add_filter( 'embed_oembed_html', 'italystrap_embed_wrap', 10, 4 );

/**
 * Add class="thumbnail" to attachment items
 */
function roots_attachment_link_class( $html ) {
	$postid = get_the_ID();
	$html = str_replace( '<a', '<a class="thumbnail"', $html );
	return $html;
}
add_filter( 'wp_get_attachment_link', 'roots_attachment_link_class', 10, 1 );

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function roots_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'roots_remove_dashboard_widgets' );


/**
 * Remove unnecessary self-closing tags
 */
function roots_remove_self_closing_tags( $input ) {
	return str_replace( ' />', '>', $input );
}
add_filter( 'get_avatar',          'roots_remove_self_closing_tags' ); // <img />
add_filter( 'comment_id_fields',   'roots_remove_self_closing_tags' ); // <input />
add_filter( 'post_thumbnail_html', 'roots_remove_self_closing_tags' ); // <img />

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function roots_remove_default_description( $bloginfo ) {
	$default_tagline = 'Just another WordPress site';
	return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter( 'get_bloginfo_rss', 'roots_remove_default_description' );

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function roots_nice_search_redirect() {
	global $wp_rewrite;
	if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->using_permalinks() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;
	if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
		wp_redirect( home_url( "/{$search_base}/" . urlencode( get_query_var( 's' ) ) ) );
		exit();
	}
}
if ( current_theme_supports( 'nice-search' ) ) {
	add_action( 'template_redirect', 'roots_nice_search_redirect' );
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function roots_request_filter( $query_vars ) {
	if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
		$query_vars['s'] = ' ';
	}

	return $query_vars;
}
add_filter( 'request', 'roots_request_filter' );

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function roots_get_search_form( $argument ) {
	if ( $argument === '' ) {
		locate_template( '/searchform.php', true, false );
	}
}
add_filter( 'get_search_form', 'roots_get_search_form' );
