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

//	$finder = \Symfony\Component\Finder\Finder::create();
//	$finder->files()->name('*.php')->in(
//		[
//			get_template_directory() . '\templates',
////			get_stylesheet_directory() . '\templates',
//		]
//	);
//
//	$files_list = [];
//
//	foreach ($finder as $file) {
//		// dumps the absolute path
////		d($file);
////		d($file->getRealPath());
//
//		// dumps the relative path to the file, omitting the filename
////		d($file->getRelativePath());
//
//		// dumps the relative path to the file
////		d($file->getRelativePathname());
//
//		$files_list[ $file->getRelativePathname() ] = $file;
//	}
//
//	d($files_list);

	$injector = \ItalyStrap\Factory\get_injector();

	$view = $injector->share('\ItalyStrap\Template\View')->make('\ItalyStrap\Template\View');

	$base_structure = [
//		'italystrap_loop'	=> 'posts/loop',
		'italystrap'		=> 'index',
	];

	$template_dir = apply_filters( 'italystrap_template_dir', 'templates' );

	foreach ( $base_structure as $filter => $file ) {

		$slug = $template_dir . DIRECTORY_SEPARATOR . $file;
		add_filter( $filter, function() use ( $view, $slug, $data ) {
			echo $view->render( $slug, $data );
		} );
	}

//		$template = $template_dir . DIRECTORY_SEPARATOR . $file;
//
//		echo $view->render( $template, $data );

	do_action( 'italystrap' );
}
