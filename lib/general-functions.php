<?php
/**
 * General Template functions
 *
 * @package ItalyStrap
 * @since 4.0.0 ItalyStrap
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Core\Navbar\Bootstrap_Nav_Menu;

/**
 * New get_search_form function
 *
 * @since 4.0.0 ItalyStrap
 *
 * @link https://codex.wordpress.org/Function_Reference/get_search_form
 * @return string Return the search form
 */
function get_search_form() {

	/**
	 * Retrieve the contents of the search WordPress query variable.
	 * The search query string is passed through esc_attr() to ensure
	 * that it is safe for placing in an html attribute.
	 *
	 * @var string
	 */
	$get_search_query = ( is_search() ) ? get_search_query() : '' ;

	$form = '<div itemscope itemtype="http://schema.org/WebSite"><meta itemprop="url" content="' . esc_attr( HOME_URL ) . '"/><form class="navbar-form navbar-right" role="search" method="get" action="' . esc_attr( HOME_URL ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction"><meta itemprop="target" content="' . esc_attr( HOME_URL ) . '?s={s}"/><div class="input-group input-group-sm"><input type="search" placeholder="' . __( 'Search now', 'ItalyStrap' ) . '" value="' . $get_search_query . '" name="s" class="form-control" itemprop="query-input"><span class="input-group-btn"><button type="submit" class="btn btn-default" value="' . __( 'Search', 'ItalyStrap' ) . '"><i class="glyphicon glyphicon-search"></i></button></span></div></form></div>';

	return apply_filters( 'italystrap_search_form', $form, $get_search_query );

}

/**
 * Get the custom header image
 * f
 * @param  int    $id The id of header image
 * @return string     The img output
 */
function get_the_custom_header_image( $id ) {

	$attr = array(
		'class'		=> "center-block img-responsive attachment-$id attachment-header size-header",
		'alt'		=> esc_attr( GET_BLOGINFO_NAME ),
		'itemprop'	=> 'image',
				);

	$attr = apply_filters( 'italystrap_custom_header_image_attr', $attr );

	$output = wp_get_attachment_image( $id , false, false, $attr );

	return apply_filters( 'italystrap_custom_header_image', $output );
}

/**
 * Function for test top menu
 */
function add_top_menu() {
/**
 * @todo Menù top da sistemare
 */
if ( has_nav_menu( 'info-menu' ) || has_nav_menu( 'social-menu' ) ) : ?>
<nav id="top-nav" class="top-nav">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pt-sm vertical-align">
				<?php
				/**
				 * Menù per i contatti
				 */
				wp_nav_menu(
					array(
						'theme_location'	=> 'info-menu',
						'depth'				=> 1,
						'container'			=> 'div',
						'container_class'	=> 'item-left',
						'fallback_cb'       => false,
						'menu_class'		=> 'list-inline social',
						'walker'			=> new Bootstrap_Nav_Menu(),
					)
				);
				/**
				 * Menù per i link sociali
				 */
				wp_nav_menu(
					array(
						'theme_location'	=> 'social-menu',
						'depth'				=> 1,
						'container'			=> 'div',
						'container_class'	=> 'item-right',
						'fallback_cb'       => false,
						'menu_class'		=> 'list-inline social',
						'link_before'		=> '<span class="item-title">',
						'link_after'		=> '</span>',
						'walker'			=> new Bootstrap_Nav_Menu(),
					)
				);
				?>
			</div>
		</div>
	</div>
</nav>
<?php endif;
}

/**
 * Append template for content header
 */
function get_template_content_header() {
	/**
	 * Get the template for displaing the header's contents (header and nav tags)
	 */
	get_template_part( 'template/content', 'header' );
}

/**
 * Funzione per aggiungere il form di ricerca nel menù di navigazione
 * Per funzionare aggiungere il parametro search con valore true all'array passato a wp_nav_menu()
 * wp_nav_menu( array( 'search' => true ) );
 *
 * @todo Aggiungere opzione per stampare il form prima o dopo wp_nav_menu()
 * @todo Aggiungere opzione nel customizer
 *
 * @param  string $nav_menu The nav menu output.
 * @param  object $args     wp_nav_menu arguments in object.
 * @return string           The nav menu output
 * @uses italystrap_get_search_form()
 */
function print_search_form_in_menu( $nav_menu, $args ) {

	if ( ! isset( $args->search ) ) {
		return $nav_menu;
	}

	return str_replace( '</div>', get_search_form() . '</div>', $nav_menu );
}
// add_filter( 'wp_nav_menu', __NAMESPACE__ . '\print_search_form_in_menu', 10, 2 );

/**
 * Display the breadcrumbs
 *
 * @param array $defaults Default array for parameters.
 * @return string Echo breadcrumbs
 */
function display_breadcrumbs( $defaults = array() ) {

	if ( ! function_exists( 'ItalyStrap\Core\breadcrumbs' ) ) {
		return;
	}

	$args = array(
		'home'	=> '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>',
	);

	breadcrumbs( $args );
}

/**
 * Get the default text for colophon
 *
 * @since 4.0.0 ItalyStrap
 *
 * @return string The dafault text for colophon
 */
function colophon_default_text() {

	return '<p class="text-muted small">&copy; <span itemprop="copyrightYear">' . esc_attr( date( 'Y' ) ) . '</span> ' . esc_attr( GET_BLOGINFO_NAME ) . ' | This website uses ' . esc_attr( ITALYSTRAP_CURRENT_THEME_NAME ) . ' powered by <a href="http://www.italystrap.it" rel="nofollow" itemprop="url">ItalyStrap</a> developed by <a href="http://www.overclokk.net" rel="nofollow" itemprop="url">Overclokk.net</a> ' . ( ( ! is_child_theme() ) ? '| Theme version: <span class="badge" itemprop="version">' . esc_attr( ITALYSTRAP_THEME_VERSION ) . '</span>' : '' ) . '</p>';

}

/**
 * Echo the colophon function
 *
 * @since 4.0.0 ItalyStrap
 *
 * @param  string $theme_mods The theme mods array.
 */
function get_the_colophon( $theme_mods ) {

	$output = ( isset( $theme_mods['colophon'] ) ) ? $theme_mods['colophon'] : colophon_default_text();

	return apply_filters( 'italystrap_colophon_output', wp_kses_post( $output ) );
}

if ( ! function_exists( 'ItalyStrap\Core\get_attr' ) ) {

	/**
	 * Build list of attributes into a string and apply contextual filter on string.
	 *
	 * The contextual filter is of the form `italystrap_attr_{context}_output`.
	 *
	 * @since 4.0.0
	 *
	 * @see In general-function on the plugin.
	 *
	 * @param  string $context    The context, to build filter name.
	 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
	 * @param  bool   $echo       True for echoing or false for returning the value.
	 *                            Default false.
	 * @param  null   $args       Optional. Extra arguments in case is needed.
	 *
	 * @return string String of HTML attributes and values.
	 */
	function get_attr( $context, array $attr = array(), $echo = false, $args = null ) {

		$html = '';

		/**
		 * This filters the array with html attributes.
		 *
		 * @var array
		 */
		$attr = (array) apply_filters( "italystrap_{$context}_attr", $attr, $context, $args );

		foreach ( $attr as $key => $value ) {

			if ( empty( $value ) ) {
				continue;
			}

			if ( true === $value ) {

				$html .= esc_html( $key ) . ' ';
			} else {

				$html .= sprintf(
					' %s="%s"',
					esc_html( $key ),
					( 'href' === $key ) ? esc_url( $value ) : esc_attr( $value )
				);
			}
		}

		/**
		 * This filters the output of the html attributes. 
		 *
		 * @var string
		 */
		$html = apply_filters( "italystrap_attr_{$context}_output", $html, $attr, $context, $args );

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

/**
 * Render the HTML tag attributes from an array
 *
 * @param  array $attr The HTML attributes with key value.
 * @return string      Return a string with HTML attributes
 */
function get_html_tag_attr( $attr = array() ) {

	$html = '';

	$attr = array_map( 'esc_attr', $attr );
	foreach ( $attr as $name => $value ) {
		$html .= " $name=" . '"' . $value . '"';
	}

	return $html;

}

/**
 * Display the classes for content element
 *
 * @since 4.0.0
 * @param string|array $class One or more classes to add to the class list.
 */
function content_class( $class = '' ) {
	/**
	 * Separates classes with a single space, collates classes for content element
	 */
	echo 'class="' . join( ' ', get_content_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array              Array of classes.
 */
function get_content_class( $class = '' ) {

	$classes = array();

	if ( ! is_array( $class ) ) {
		$classes[] = trim( $class );
	} else {
		$classes = array_merge( $classes, $class );
	}
	

	$classes[] = trim( $class );

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filter the list of CSS content classes for the current post or page.
	 *
	 * @var array
	 */
	$classes = apply_filters( 'italystrap_content_class', $classes, $class );

	return  array_flip( array_flip( $classes ) );

}

/**
 * Add a bootstrap button class to cancel reply
 * @param string $formatted_link Cancel reply a tag
 * @param string $link           Link to reply
 * @param string $text           Text to display
 */
function add_class_button_to_cancel_reply( $formatted_link, $link, $text ){

	return str_replace( '<a ', '<a class="btn btn-danger btn-xs" ', $formatted_link);

}
add_filter( 'cancel_comment_reply_link', '\ItalyStrap\Core\add_class_button_to_cancel_reply', 10, 3 );

/**
 * Add a rel="nofollow" and Bootstrap button class to the comment reply links
 *
 * @link http://www.robertoiacono.it/aggiungere-nofollow-link-rispondi-commenti-wordpress/ (only for nofollow)
 * 
 * @since 1.9.1
 * 
 * @param string $link Comment reply url button
 */
function add_nofollow_and_bootstrap_button_css_to_reply_link( $link ) {

	$search = array( '")\'>', 'comment-reply-link');
	$replace = array( '")\' rel=\'nofollow\'>', 'btn btn-primary btn-sm pull-right');
	$link = str_replace($search, $replace, $link);

	return $link;
}
add_filter( 'comment_reply_link', '\ItalyStrap\Core\add_nofollow_and_bootstrap_button_css_to_reply_link' );

/**
 * Display a message if comments are closed
 * @return string Return message
 */
function display_message_if_comments_are_closed(){

    echo '<div class="alert alert-warning">' . __('Comments are closed.', 'ItalyStrap') . '</div>';

}
add_action( 'comment_form_comments_closed', '\ItalyStrap\Core\display_message_if_comments_are_closed' );


/**
 * Argument for standard comment_form()
 * @param  string $comment_author Author of comment
 * @param  string $user_identity  Identity of user logged in
 * @return array                  An array with arguments for comment_form()
 */
function comment_form_args( $comment_author, $user_identity ){

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	/**
	 * The comment field with bootstrap style
	 * @var array
	 */
	$comment_field = array(

		'author'	=> 
			'<div class="form-group comment-form-author"><label for="author" class="sr-only">' . __( 'Name', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) <span class="required">*</span>', 'ItalyStrap') : '' ) . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="author" id="author" value="' . esc_attr( $comment_author ) . '" placeholder="' . __('Name','ItalyStrap') . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" tabindex="1"' . ( $req ? 'aria-required="true"' : '') . ' title="' . __( 'Name', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '"/></div></div>',

		'email'		=>
			'<div class="form-group comment-form-email"><label for="email" class="sr-only">' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) <span class="required">*</span>', 'ItalyStrap') : '' ) . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" tabindex="2" aria-describedby="email-notes" ' . $aria_req . $html_req  . ' title="' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" /></div></div>',

		'url'		=>
			'<div class="form-group comment-form-url"><label for="url" class="sr-only">' . __( 'Website' ,'ItalyStrap') . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input type="url" class="form-control" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website (optional)' ,'ItalyStrap') . '" tabindex="3" title="' . __( 'Website (optional)' ,'ItalyStrap') . '" /></div></div>',

		);

	$comment_field = apply_filters( 'italystrap_comment_form_default_fields', $comment_field, $comment_author, $commenter, $req, $aria_req, $html_req );

	$comment_array = array(
		'fields'			=>	$comment_field,
		'class_submit'		=>	'btn btn-large btn-primary',
		'format'			=>	'html5',
		'comment_field' 	=>
			'<div class="form-group comment-form-comment"><label for="comment" class="sr-only">' . _x( 'Comment', 'noun' ) . '</label><textarea class="form-control" name="comment" id="comment" placeholder="' . __( 'Write your comment here' ,'ItalyStrap') . '" tabindex="4" rows="6" aria-required="true" title="' . __( 'Write your comment here' ,'ItalyStrap') . '"></textarea></div>',
		'logged_in_as'		=>
			'<p class="logged-in-as">' . sprintf( 
				__( 'Logged in as <a href="%1$s" class="btn btn-primary btn-xs">%2$s</a>. <a href="%3$s" title="Log out of this account" class="btn btn-warning btn-xs">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		'must_log_in'		=>
			'<p class="alert alert-danger must-log-in">' . sprintf( __( 'You must be <a href="%s" class="alert-link">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		// 'cancel_reply_link'	=> '<span class="btn btn-danger btn-xs">' . __( 'Cancel reply' ) . '</span>',

		);

	return $comment_array = apply_filters( 'italystrap_comment_form_defaults', $comment_array, $user_identity, $comment_field );

}

/**
 * Pagination for comment
 * @since ItalyStrap 3.1
 * @return string Return pagination
 */
function comment_pagination(){

	if ( get_comment_pages_count() > 1 && get_option('page_comments') ){ ?>

		<nav class="text-center" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<ul class="pagination pagination-sm">

			<?php 
			/**
			 * http://wordpress.stackexchange.com/questions/125389/return-paginate-comments-links-as-array
			 * Then I modify below code, now print bootstrap style correctly
			 */
			$pages = paginate_comments_links( 
				array( 
					'echo'		=> false,
					'type'		=> 'array',
					'prev_text'	=> __( '&laquo; Previous comments' , 'ItalyStrap' ),
					'next_text'	=> __( 'Next comments &raquo;', 'ItalyStrap' ),
					)
				);
			if ( is_array( $pages ) ){
				$pages = str_replace('<a', '<a itemprop="url"', $pages);
				foreach($pages as $page){
					$position = strpos($page, '<span');
					if ( $position === false )
						echo '<li itemprop="name">' . $page . '</li>';
					else
						echo '<li class="active" itemprop="name">' . $page . '</li>';
				}
			}
			?>

			</ul>
		</nav>

	<?php }

}

/**
 * Is comment reply
 *
 * @return bool Return true if the comment is open.
 */
function is_comment_reply() {

	return (bool) is_singular() && comments_open() && get_option( 'thread_comments' );
}

/**
 * Fallback function for custom background.
 */
function _custom_background_cb() {

	global $italystrap_customizer;

	if ( ! $italystrap_customizer ) {
		$italystrap_customizer = new \ItalyStrap\Customizer\Customizer;
	}

	$italystrap_customizer->custom_background_cb();

}

/**
 * Get the content width
 *
 * @param  string $value [description]
 * @return string        [description]
 */
function get_content_width( $container_width, $column, $content_column_width, $gutter ) {

	return $container_width / $column * $content_column_width - $gutter;

}

/**
 * Is static front page
 *
 * @return bool Return true if it is a static page selected for front page, not blog
 */
function is_static_front_page() {

	return (bool) is_front_page() && ! is_home();

}
