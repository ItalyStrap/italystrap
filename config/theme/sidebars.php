<?php
/**
 * Array definition for Theme parent sidebar registration.
 * This will be mantained for backward compatibility.
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\HTML\open_tag;
use function ItalyStrap\HTML\close_tag;
use function ItalyStrap\HTML\get_attr;
use ItalyStrap\Theme\SidebarsSubscriber as S;

return apply_filters(
	'italystrap_sidebars_registered',
	[
		'sidebar-1'		=> [
			S::NAME				=> __( 'Sidebar', 'italystrap' ),
			S::ID				=> 'sidebar-1',
	//		S::BEFORE_WIDGET	=>
			// '<div ' . get_attr( 'sidebar_1', ['id' => '%1$s', 'class' => 'widget %2$s col-sm-6 col-md-12'] ) . '>',
	//		S::AFTER_WIDGET		=> '</div>',
		],
	]
);
