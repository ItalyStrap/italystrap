<?php
/**
 * WC_Nav_Menu Template API
 *
 * This file add a WC_Nav_Menu suport for the theme
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\WooCommerce;

use ItalyStrap\Event\Subscriber_Interface;

/**
 * WC_Nav_Menu
 */
class WC_Nav_Menu implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'woocommerce_sidebar' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'				=> 'method_name',
			'woocommerce_sidebar'	=> 'main_container_end',
		);
	}

	public static function get_subscribed_events() {
		return [];
	}

	function add_qta_number_to_chart_icon( $item_output, $item, $depth, $args ) {

		// var_dump( $item_output );
		// var_dump( $item->classes );
		/**
		 * @link https://gist.github.com/mikejolley/2044101
		 */

		$qta = '<li><a class="cart-contents" href="' . WC()->cart->get_cart_url() . '" title="' . __( 'View your shopping cart', 'italystrap' ) . '"><span class="glyphicon glyphicon-shopping-cart"></span><span class="badge" style="color:#fff;position:absolute;top:5px;right:5px">' . WC()->cart->get_cart_contents_count() . '</span></a></li>';

		if ( in_array( 'cart', $item->classes ) ) {
			$item_output .= $qta;
		}

		return $item_output;
	}
	// add_filter( 'walker_nav_menu_start_el', __NAMESPACE__ . '\add_qta_number_to_chart_icon', 10, 4 );



	function get_the_account() {

		$account = '';

		if ( is_user_logged_in() ) {

				$account = '<li><a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" title="' . __( 'My Account', 'italystrap' ) . '"><span class="glyphicon glyphicon-user"></span></a></li>';

		} else {

				$account = '<li><a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '" title="' . __( 'Login / Register', 'italystrap' ) . '"><span class="glyphicon glyphicon-user"></span>' . __( 'Login / Register', 'italystrap' ) . '</a></li>';
		}

			return $account;
	}

	function get_the_wc_cart() {

		$cart = '';

		$cart = '<li><a class="cart-contents" href="' . esc_url( WC()->cart->get_cart_url() ) . '" title="' . __( 'View your shopping cart', 'italystrap' ) . '"><span class="glyphicon glyphicon-shopping-cart"></span><span class="badge" style="color:#fff;position:absolute;top:5px;right:5px;background-color:red;">' . esc_attr( WC()->cart->get_cart_contents_count() ) . '</span></a></li>';

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

}
