<?php
declare(strict_types=1);

namespace ItalyStrap;

return \apply_filters( 'register_nav_menu_locations',
	[
		'main-menu'			=> __( 'Main Menu', 'italystrap' ),
		'secondary-menu'	=> __( 'Secondary Menu', 'italystrap' ),
		'social-menu'		=> __( 'Social Menu', 'italystrap' ),
		'info-menu'			=> __( 'Info Menu', 'italystrap' ),
		'footer-menu'		=> __( 'Footer Menu', 'italystrap' ),
	]
);
