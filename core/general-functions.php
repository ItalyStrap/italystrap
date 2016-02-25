<?php namespace ItalyStrap\Core;
/**
 * General Template functions
 *
 * @package ItalyStrap
 * @since 4.0.0 ItalyStrap
 */

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

	if ( ! class_exists( 'ItalyStrapBreadcrumbs' ) )
		return;

		$defaults = array(
			'home'	=> '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>',
			);

		new \ItalyStrapBreadcrumbs( $defaults );
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
 * @param  string $italystrap_theme_mods The theme mods array.
 */
function get_the_colophon( $italystrap_theme_mods ) {

	$output = ( isset( $value['colophon'] ) ) ? $value['colophon'] : colophon_default_text();

	return apply_filters( 'italystrap_colophon_output', wp_kses_post( $output ) );
}
