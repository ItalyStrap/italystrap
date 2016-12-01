<?php
/**
 * This is a configuration file for woocommerce
 *
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Echo the closed tag
 */
function main_container_end() {
	echo '</div></main>';
	do_action( 'italystrap_after_main' );
}
add_action( 'woocommerce_sidebar', __NAMESPACE__ . '\main_container_end', 10 );

/**
 * Add edit button to single product post
 */
function add_edit_post_to_product_single() {

	$button = array(
		'open'	=> sprintf(
			'<span %s>',
			get_attr( 'single_product_edit_post_link', array( 'class' => 'margin-btn btn btn-sm btn-primary' ) )
			),
		'close'	=> '</span>',
		);

	edit_post_link( __( 'Edit', 'ItalyStrap' ), $button['open'], $button['close'] );

}
add_action( 'woocommerce_after_single_product', __NAMESPACE__ . '\add_edit_post_to_product_single', 11 );



/**
 * Aggiungo la classe form-control agli input di checkupy
 *
 * @param array $args Argomenti dell'array
 */
function add_new_css_class_to_form_field_check_out( $args ) {

	$args['input_class'][] = 'form-control';

	// var_dump($args['input_class']);
	return $args;

}
// add_filter( 'woocommerce_form_field_args', __NAMESPACE__ . '\add_new_css_class_to_form_field_check_out' );



function add_qta_number_to_chart_icon( $item_output, $item, $depth, $args ) {

	// var_dump( $item_output );
	// var_dump( $item->classes );
	/**
	 * @link https://gist.github.com/mikejolley/2044101
	 */

	$qta = '<li><a class="cart-contents" href="' . WC()->cart->get_cart_url() . '" title="' . __( 'View your shopping cart' ) . '"><span class="glyphicon glyphicon-shopping-cart"></span><span class="badge" style="color:#fff;position:absolute;top:5px;right:5px">' . WC()->cart->get_cart_contents_count() . '</span></a></li>';

	if ( in_array( 'cart', $item->classes ) ) {
		$item_output .= $qta;
	}

	return $item_output;
}
// add_filter( 'walker_nav_menu_start_el', __NAMESPACE__ . '\add_qta_number_to_chart_icon', 10, 4 );



function get_the_account() {

	$account = '';

	if ( is_user_logged_in() ) {

			$account = '<li><a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" title="' . __( 'My Account','woothemes' ) . '"><span class="glyphicon glyphicon-user"></span></a></li>';

	} else {

			$account = '<li><a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" title="' . __( 'Login / Register','woothemes' ) . '"><span class="glyphicon glyphicon-user"></span>' . __( 'Login / Register','woothemes' ) . '</a></li>';
	}

		return $account;
}

function get_the_wc_cart() {

	$cart = '';

	$cart = '<li><a class="cart-contents" href="' . esc_url( WC()->cart->get_cart_url() ) . '" title="' . __( 'View your shopping cart' ) . '"><span class="glyphicon glyphicon-shopping-cart"></span><span class="badge" style="color:#fff;position:absolute;top:5px;right:5px;background-color:red;">' . esc_attr( WC()->cart->get_cart_contents_count() ) . '</span></a></li>';

	return $cart;
}

function add_woocommerce_menu( $nav_menu, $args ) {

	if ( 'main-menu' !== $args->theme_location ) {
		return $nav_menu;
	}

	$account = get_the_account();

	$cart = get_the_wc_cart();

	return get_search_form() . $nav_menu . '<ul class="nav navbar-nav navbar-right wc-menu" style="padding-right:15px;">' . $account . $cart . '</ul>';

}
// add_filter( 'wp_nav_menu', __NAMESPACE__ . '\add_woocommerce_menu', 10, 2 );



function add_woocommerce_menu_to_navbrand( $output, $navbar_id ) {

	$account = get_the_account();

	$cart = get_the_wc_cart();

	return $output . '<ul class="nav navbar-nav text-right list-inline wc-menu-mobile" style="padding-right:15px;">' . $account . $cart . '</ul>';
}

// add_filter( 'italystrap_navbar_brand', __NAMESPACE__ . '\add_woocommerce_menu_to_navbrand', 10, 2 );

/**
 * Function description
 *
 * @param mixed  $args  Form elements arguments.
 * @param string $key   Form elements key for ID attribute.
 * @param string $value The value of the form elements (default: null).
 *
 * @return string        [description]
 */
function form_field_args( array $args, $key, $value ) {

	$args['class'][] = 'form-group';
	$args['input_class'][] = 'form-control';

	return $args;

}
add_filter( 'woocommerce_form_field_args', __NAMESPACE__ . '\form_field_args', 10, 3 );
