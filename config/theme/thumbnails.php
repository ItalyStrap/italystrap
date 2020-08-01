<?php
declare(strict_types=1);
namespace ItalyStrap;

use function \ItalyStrap\Factory\get_config;
use ItalyStrap\Theme\ThumbnailsSubscriber as T;

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

/**
 * @see \ItalyStrap\Core\get_content_width()
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
			T::WIDTH	=> 45,
			T::HEIGHT	=> 45,
			T::CROP		=> true,
		],

		/**
		 * La full-width serve solo per la pagina omonima
		 * Si potrebbe invece settare "large" a 1140 (verificare se 1170 va bene) e risparmiare spazio avendo una immagine di meno poichè entrambe non vengono croppate
		 * "large" può essere settata anche con altezza a 9999
		 */
		'full-width'			=> [
			T::WIDTH	=> $container - $gutter,
			T::HEIGHT	=> 9999,
			T::CROP		=> false,
		],
		'one_half'			=> [
			T::WIDTH	=> $container / 2 - $gutter,
			T::HEIGHT	=> ($container / 2 - $gutter) * 3 / 4,
			T::CROP		=> true,
		],
		'one_third'			=> [
			T::WIDTH	=> $container / 3 - $gutter,
			T::HEIGHT	=> ($container / 3 - $gutter) * 3 / 4,
			T::CROP		=> true,
		],
		'one_fourth'			=> [
			T::WIDTH	=> $container / 4 - $gutter,
			T::HEIGHT	=> ($container / 4 - $gutter) * 3 / 4,
			T::CROP		=> true,
		],
		'one_six'			=> [
			T::WIDTH	=> $container / 6 - $gutter,
			T::HEIGHT	=> ($container / 6 - $gutter) * 3 / 4,
			T::CROP		=> true,
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

	'content_width'		=> get_config()->get( 'content_width' ),
];