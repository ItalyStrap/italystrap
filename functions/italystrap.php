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
 * @param string $file
 * @param array $data
 * @throws \Auryn\ConfigException
 * @throws \Auryn\InjectionException
 */
function italystrap( $file = 'index', array $data = [] ) {

	$injector = \ItalyStrap\Factory\get_injector();

	$view = $injector->share('\ItalyStrap\Template\View')->make('\ItalyStrap\Template\View');

	$base_structure = [
//		'italystrap_loop'	=> 'posts/loop',
		'italystrap'		=> 'index',
	];

	$template_dir = apply_filters( 'italystrap_template_dir', 'templates' );

	foreach ( $base_structure as $filter => $file ) {

		$template = $template_dir . DIRECTORY_SEPARATOR . $file;
		add_filter( $filter, function() use ( $view, $template, $data ) {
			echo $view->render( $template, $data );
		} );
	}

//		$template = $template_dir . DIRECTORY_SEPARATOR . $file;
//
//		echo $view->render( $template, $data );

	do_action( 'italystrap' );
}
