<?php
/**
 * Array definition for Theme parent sidebar registration.
 * This will be mantained for backward compatibility.
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag, close_tag, get_attr};
use ItalyStrap\Theme\SidebarsSubscriber as S;

/**
 * @todo In questi settings vengono registrate anche le widget_area
 *       del footer e la key viene usate per calcolare la larghezza della colonna.
 *       Vedi Classe Footer_Widget_area
 * @see \ItalyStrap\Components\Footers\WidgetArea
 */
return apply_filters( 'italystrap_sidebars_registered',
	[
		'sidebar-1'		=> [
			S::NAME				=> __( 'Sidebar', 'italystrap' ),
			S::ID				=> 'sidebar-1',
			S::BEFORE_WIDGET	=> '<div ' . get_attr( 'sidebar_1', ['id' => '%1$s', 'class' => 'widget %2$s col-sm-6 col-md-12'] ) . '>',
			S::AFTER_WIDGET		=> '</div>',
		],

		'footer-box-1'	=> [
			S::NAME				=> __( 'Footer Box 1', 'italystrap' ),
			S::ID				=> 'footer-box-1',
			S::DESCRIPTION		=> __( 'Footer box 1 widget area.', 'italystrap' ),
		],

		'footer-box-2'	=> [
			S::NAME				=> __( 'Footer Box 2', 'italystrap' ),
			S::ID				=> 'footer-box-2',
			S::DESCRIPTION		=> __( 'Footer box 2 widget area.', 'italystrap' ),
		],

		'footer-box-3'	=> [
			S::NAME				=> __( 'Footer Box 3', 'italystrap' ),
			S::ID				=> 'footer-box-3',
			S::DESCRIPTION		=> __( 'Footer box 3 widget area.', 'italystrap' ),
		],

		'footer-box-4'	=> [
			S::NAME				=> __( 'Footer Box 4', 'italystrap' ),
			S::ID				=> 'footer-box-4',
			S::DESCRIPTION		=> __( 'Footer box 4 widget area.', 'italystrap' ),
		],
	]
);
