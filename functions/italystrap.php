<?php

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

//	$injector = \ItalyStrap\Factory\get_injector();
//
//	$director = $injector->make( '\ItalyStrap\Builders\Director' );
//	$director->create_page();

//	$config = \ItalyStrap\Factory\get_config();

//	$view = \ItalyStrap\Factory\get_view();

//	$base_structure = [
//
//		'italystrap_entry'			=> 'posts/post',
//		'italystrap_content_none'	=> 'posts/none',
//
//		'italystrap_loop'			=> 'posts/loop',
//		'italystrap'				=> 'index',
//	];

//	$template_dir = $config->get( 'template_dir' );
//
//	foreach ( $base_structure as $filter => $file ) {
//
//		$slug = $template_dir . DIRECTORY_SEPARATOR . $file;
//		add_filter( $filter, function() use ( $view, $slug, $data ) {
//			echo $view->render( $slug, $data );
//		} );
//	}

	do_action( 'italystrap' );
}
