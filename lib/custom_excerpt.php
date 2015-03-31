<?php
/**
 * New function to set excerpt lenght and show "more link"
 * @link http://stackoverflow.com/questions/10081129/why-cant-i-override-wps-excerpt-more-filter-via-my-child-theme-functions
 *
 * Codex link:
 * @link http://codex.wordpress.org/Excerpt
 * @link http://codex.wordpress.org/Customizing_the_Read_More
 *
 * The quicktag <!--more--> doesn't work with the_excerpt() and get_the_excerpt,
 * it works only with the_content and get_the_content
 * Use the box excerpt inside admin panel
 */

add_action( 'after_setup_theme', 'italystrap_excerpt_more_lenght' );

if ( !function_exists( 'italystrap_excerpt_more_lenght' ) ):

	function italystrap_excerpt_more_lenght() {

	    // Escerpt read more link function
	    function italystrap_read_more_link() {

	    	global $post;
			return ' <a href="'. get_permalink( $post->ID ) . '">... ' . __( 'Read more', 'ItalyStrap' ) . '</a>';

	    }
	    // Function to override
	    function italystrap_custom_excerpt_more( $output ) {

	        if ( has_excerpt() && !is_attachment() ) {
	            $output .= italystrap_read_more_link();
	        }
	        return $output;

	    }

	    add_filter( 'get_the_excerpt', 'italystrap_custom_excerpt_more' );
	    add_filter( 'excerpt_more', 'italystrap_read_more_link' );

	    // Excerpt lenght function
	    function italystrap_excerpt_length( $length ) {

	    	if ( is_home() || is_front_page() ) {
	    		return 25;
	    	}else{
				return 50;
			}
	    }
	    add_filter( 'excerpt_length', 'italystrap_excerpt_length' );

	}
endif; // italystrap_excerpt_more_lenght


/**
 * Function deprecated
 * 
 */
// function custom_excerpt_length( $length ) {
// 	if ( is_home() || is_front_page() ){
// 	return 30;}
// 	else{
// 	return 50;
// 	}
// }
// add_filter( 'excerpt_length', 'custom_excerpt_length', 20 );

// function new_excerpt_more( $more ) {
// 	if ( is_home() || is_front_page() ){
// 	return '';}
// 	else{
// 	return ' <a href="'. get_permalink() . '">... Continua a leggere</a>';
// 	}
// }
// add_filter('excerpt_more', 'new_excerpt_more');