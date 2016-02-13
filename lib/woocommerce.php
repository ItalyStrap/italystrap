<?php
/**
 * This is a configuration file for woocommerce
 *
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

/**
 * Remove WooCommerce action
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'my_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'my_theme_wrapper_end', 10 );
add_action( 'woocommerce_sidebar', 'my_theme_wrapper', 10 );

/**
 * Echo the open tag
 */
function my_theme_wrapper_start() {
	echo '<div class="container"><div class="row"><section class="col-md-8">';
}

/**
 * Echo the closed tag
 */
function my_theme_wrapper_end() {
	echo '</section>';
}

/**
 * Echo the closed tag
 */
function my_theme_wrapper() {
	echo '</div></div>';
}
