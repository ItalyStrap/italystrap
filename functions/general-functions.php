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

use ItalyStrap\Config\Config;
use ItalyStrap\HTML;

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
	$get_search_query = is_search() ? get_search_query() : '' ;

	$form = '<div itemscope itemtype="https://schema.org/WebSite"><meta itemprop="url" content="' . esc_attr( HOME_URL ) . '"/><form class="navbar-form navbar-right" role="search" method="get" action="' . esc_attr( HOME_URL ) . '" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction"><meta itemprop="target" content="' . esc_attr( HOME_URL ) . '?s={s}"/><div class="input-group input-group-sm"><input type="search" placeholder="' . __( 'Search now', 'italystrap' ) . '" value="' . $get_search_query . '" name="s" class="form-control" itemprop="query-input"><span class="input-group-btn"><button type="submit" class="btn btn-default" value="' . __( 'Search', 'italystrap' ) . '"><i class="glyphicon glyphicon-search"></i></button></span></div></form></div>';

	return apply_filters( 'italystrap_search_form', $form, $get_search_query );

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
 * Get the default text for colophon
 *
 * @since 4.0.0 ItalyStrap
 *
 * @return string The dafault text for colophon
 */
function colophon_default_text() {

    $powered = sprintf(
        '<a%s>ItalyStrap</a>',
        \ItalyStrap\HTML\get_attr( 'powered', [
                'href'      => '//www.italystrap.it',
                'rel'       => 'nofollow',
                'itemprop'  => 'url',
        ] )
    );

    $developed = sprintf(
        '<a%s>Overclokk.net</a>',
		\ItalyStrap\HTML\get_attr( 'developed', [
			'href'      => '//www.overclokk.net',
			'rel'       => 'nofollow',
			'itemprop'  => 'url',
		] )
    );

	return sprintf(
		'<p class="text-muted small">&copy; <span itemprop="copyrightYear">%1$d</span> %2$s | This website uses %3$s powered by %5$s developed by %6$s %4$s</p>',
		esc_attr( date( 'Y' ) ),
		esc_attr( GET_BLOGINFO_NAME ),
		esc_attr( ITALYSTRAP_CURRENT_THEME_NAME ),
		! is_child_theme() ? '| Theme version: <span itemprop="version">' . esc_attr( ITALYSTRAP_THEME_VERSION ) . '</span>' : '',
		$powered,
		$developed
	);

}

/**
 * Return colophon text
 *
 * @since 4.0.0 ItalyStrap
 *
 * @param \ItalyStrap\Config\Config_Interface $config
 * @return string
 */
function get_the_colophon() {
	$output = \ItalyStrap\Factory\get_config()->get( 'colophon', '' );
	return apply_filters( 'italystrap_colophon_output', wp_kses_post( $output ) );
}

/**
 * Echo colophon text
 *
 * @since 4.0.0 ItalyStrap
 *
 * @param \ItalyStrap\Config\Config_Interface $config
 */
function the_colophon() {
	echo get_the_colophon();
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
		 * @param  array  $attr    The array with all HTML attributes to render.
		 * @param  string $context The context in wich this functionis called.
		 * @param  null   $args    Optional. Extra arguments in case is needed.
		 *
		 * @var array
		 */
		$attr = (array) apply_filters( "italystrap_{$context}_attr", $attr, $context, $args );

		foreach ( $attr as $key => $value ) {

			if ( empty( $value ) ) {
				continue;
			}

			if ( true === $value ) {

				$html .= ' ' . esc_html( $key );
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
		 * @param  string $html    The HTML attr output.
		 * @param  array  $attr    The array with all HTML attributes to render.
		 * @param  string $context The context in wich this functionis called.
		 * @param  null   $args    Optional. Extra arguments in case is needed.
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

/**
 * WP Parse Args recusrive
 *
 * @link http://mekshq.com/recursive-wp-parse-args-wordpress-function/
 *
 * @param  array &$args    The array.
 * @param  array $defaults The default array.
 *
 * @return array           The array merged.
 */
function wp_parse_args_recursive( &$args, $defaults ) {
	$args = (array) $args;
	$defaults = (array) $defaults;
	$result = $defaults;
	foreach ( $args as $k => &$v ) {
		if ( is_array( $v ) && isset( $result[ $k ] ) ) {
			$result[ $k ] = wp_parse_args_recursive( $v, $result[ $k ] );
		} else {
			$result[ $k ] = $v;
		}
	}
	return $result;
}

/**
 * Register theme position
 *
 * @param  string $new_position The position registered.
 * @return array                Array with theme position.
 */
function register_theme_positions( array $new_position ) {

	return array_merge(
		\ItalyStrap\Config\get_config_file_content( 'theme-positions' ),
        $new_position
    );
}
add_filter( 'italystrap_theme_positions', __NAMESPACE__ . '\register_theme_positions' );
/**
 * This filter is deprecated. Use 'italystrap_theme_positions' instead.
 */
add_filter( 'italystrap_widget_area_position', __NAMESPACE__ . '\register_theme_positions' );

/**
 * Register theme width
 *
 * @param  string $position The position registered.
 * @return array            Array with theme position.
 */
function register_theme_width( array $new_width ) {

	$with = \ItalyStrap\Config\get_config_file_content( 'theme-width' );

	return array_merge( $with, $new_width );
}
add_filter( 'italystrap_theme_width', __NAMESPACE__ . '\register_theme_width' );

/**
 * Get the template parts settings.
 * This methos has to be called inside a loop.
 *
 * @return array Return the array with template part settings.
 */
function get_template_settings() {

	static $parts = null;

	/**
	 * Cache the post_meta data
	 */
	if ( ! $parts ) {

		/**
		 * This is a little different from the layout settings because
		 * only in singular it must return the data from post_meta
		 *
		 * @var [type]
		 */
//			$parts = ! is_singular() ? (array) self::$post_content_template : (array) get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
		$parts = (array) \ItalyStrap\Factory\get_config()->get('post_content_template');
	}

	return (array) apply_filters( 'italystrap_get_template_settings', $parts );
}

/**
 * @param array $theme_mods
 * @TODO Da sviluppare per il customizer
 * https://core.trac.wordpress.org/ticket/24844
 */
function get_theme_mods_in_customizer ( array $theme_mods = [] ) {
    if ( is_customize_preview() ) {
        foreach ( $theme_mods as $key => $value ) {
            $theme_mods[ $key ] = apply_filters( 'theme_mod_' . $key, $value );
        }
    }
}

/**
 * This class has to be loaded before the init of all classes.
 * @TODO Required plugins
 *
 * @var \ItalyStrap\Admin\Required_Plugins\Register
 */
// add_action( 'after_setup_theme', function() use ( $required_plugins ) {
// 	$required_plugins = new \ItalyStrap\Required_Plugins\Register;
// 	add_action( 'tgmpa_register', array( $required_plugins, 'init' ) );
// }, 10, 1 );
