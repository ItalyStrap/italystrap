<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 25/01/2019
 * Time: 08:18
 */

namespace ItalyStrap;

/**
 * Function for loading the template.
 *
 * @param  string $file_name The file_name on this function is called.
 */
function italystrap( $file_name = 'index' ) {

	$template_dir = apply_filters( 'italystrap_template_dir', 'templates' );

	require locate_template(
		$template_dir . DIRECTORY_SEPARATOR . $file_name . '.php'
	);

	do_action( 'italystrap' );
}
