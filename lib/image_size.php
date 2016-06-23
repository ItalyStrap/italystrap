<?php
/**
 *  Use this file for set your image size in template
 *  @link http://codex.wordpress.org/Function_Reference/add_image_size
 */

/**
 * Display image size 740x370 in single and page
 */
// add_image_size( 'article-thumb', 740, 370, true);
/**
 * Display image size 253x126 in index and correlated
 */
// add_image_size( 'article-thumb-index', 253, 126, true);
/**
 * Display image size 1130x565 in full-width page
 */
add_image_size( 'full-width', 1140, 9999 );

/**
 * Image size displayed in the navbar brand image
 *
 * @see Class Navbar::get_navbar_brand()
 */
add_image_size( 'navbar-brand-image', 45, 45, true);

/**
 * col-md-12 1140
 * col-md-11 1043
 * col-md-10 945
 * col-md-9 848
 * col-md-8 750
 * col-md-7 653
 * col-md-6 555
 * col-md-5 458
 * col-md-4 360
 * col-md-3 263
 * col-md-2 165
 * col-md-1 68
 */