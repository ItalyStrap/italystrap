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
 * Remove WooCommerce action
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', __NAMESPACE__ . '\wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', __NAMESPACE__ . '\wrapper_end', 10 );
add_action( 'woocommerce_sidebar', __NAMESPACE__ . '\wrapper', 10 );

/**
 * Echo the open tag
 */
function wrapper_start() {
	echo '<div class="container"><div class="row"><section class="col-md-8">';
}

/**
 * Echo the closed tag
 */
function wrapper_end() {
	echo '</section>';
}

/**
 * Echo the closed tag
 */
function wrapper() {
	echo '</div></div>';
}
