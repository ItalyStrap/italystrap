<?php
/**
 * General functions for admin
 *
 * @package ItalyStrap
 * @since 4.0.0 ItalyStrap
 */

namespace ItalyStrap\Admin;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Add Custom CSS in visual editor
 *
 * @link http://codex.wordpress.org/Function_Reference/add_editor_style
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @todo Cambiare nome al file in 'editor-style.css'
 *
 * Leggere qui perché forse c'è un problema con i font, non prende il path giusto
 * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
 * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
 */
function add_editor_styles() {

	/**
	 * @todo Cambiare nome al file in 'editor-style.css'
	 */
	$style_url = file_exists( STYLESHEETPATH . '/css/editor-style.css' ) ? STYLESHEETURL . '/css/editor-style.css' : TEMPLATEURL . '/css/editor-style.css';

	$arg = apply_filters( 'italystrap_visual_editor_style', array( $style_url ) );

	add_editor_style( $arg );

}

add_action( 'after_setup_theme', 'ItalyStrap\Admin\add_editor_styles' );
