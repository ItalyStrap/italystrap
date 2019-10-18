<?php
declare(strict_types=1);
namespace ItalyStrap;

use function \ItalyStrap\Factory\get_config;

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

$container = 1170;
$gutter = 30;
$col = 12;

/**
 * Set the default image
 * @link http://codex.wordpress.org/Function_Reference/add_image_size
 */
return [
	'sizes'	=> [
		'navbar-brand-image'	=> [
			'width'		=> 45,
			'height'	=> 45,
			'crop'		=> true,
		],
		/**
		 * La full-width serve solo per la pagina omonima
		 * Si potrebbe invece settare "large" a 1140 (verificare se 1170 va bene) e risparmiare spazio avendo una immagine di meno poichè entrambe non vengono croppate
		 * "large" può essere settata anche con altezza a 9999
		 */
		'full-width'			=> [
			'width'		=> $container - $gutter,
			'height'	=> 9999,
			'crop'		=> false,
		],
		'one_half'			=> [
			'width'		=> $container / 2 - $gutter,
			'height'	=> ($container / 2 - $gutter) * 3 / 4,
			'crop'		=> true,
		],
		'one_third'			=> [
			'width'		=> $container / 3 - $gutter,
			'height'	=> ($container / 3 - $gutter) * 3 / 4,
			'crop'		=> true,
		],
		'one_fourth'			=> [
			'width'		=> $container / 4 - $gutter,
			'height'	=> ($container / 4 - $gutter) * 3 / 4,
			'crop'		=> true,
		],
		'one_six'			=> [
			'width'		=> $container / 6 - $gutter,
			'height'	=> ($container / 6 - $gutter) * 3 / 4,
			'crop'		=> true,
		],
	],

	/**
	 * @todo Da sviluppare meglio
	 * @todo Valutare l'utilizzo delle frazioni e creare:
	 * un_mezzo
	 * un_terzo
	 * un_quarto
	 * un_sesto
	 * direi che queste siano più che sufficienti
	 * Il calcolo si può fare:
	 * 1170 / 4 - gutter(30) e ottengo un_quarto
	 *
	 * add_image_size( 'one_fourth', 263, 238, true );
	 *
	 * l'altezza proporzionata si calcola:
	 * 4/3
	 * $width : 4 = $height : 3
	 * $width * 3 / 4;
	 */
	'breakpoint'					=> [
//			 'xs'	=> 480,
		// 'sm'	=> 768,
		// 'md'	=> 992,
		// 'lg'	=> 1200,
	],

	'content_width'	=> get_config()->get( 'content_width' ),
];