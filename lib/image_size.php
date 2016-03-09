<?php
/**
 *  Use this file for set your image size in template
 *  @link http://codex.wordpress.org/Function_Reference/add_image_size
 */
/**
 * Display image size in index carousel
 */
add_image_size( 'slide', 1140, 500, true);
/**
 * Display image size 740x370 in single and page
 */
add_image_size( 'article-thumb', 740, 370, true);
/**
 * Display image size 253x126 in index and correlated
 */
add_image_size( 'article-thumb-index', 253, 126, true);
/**
 * Display image size 1130x565 in full-width page
 */
add_image_size( 'full-width', 1130, 565, true);

/**
 * Image size displayed in the navbar brand image
 *
 * @see Class Navbar::get_navbar_brand()
 */
add_image_size( 'navbar-brand-image', 45, 45, true);