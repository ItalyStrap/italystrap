<?php

namespace ItalyStrap;

return [
	/**
	 * ========================================================================
	 *
	 * Autoload Concrete Classes
	 * Loaded on admin and front-end
	 * @TODO Maybe it should be called subscribers because they are subscribed and not only instantiated
	 *
	 * string
	 *
	 * ========================================================================
	 */
	'subscribers'				=> [
//		'\ItalyStrap\Router\Router', // Anche questo da testare meglio
		// '\ItalyStrap\Core\Router\Controller', // Da testare meglio
		Customizer\Theme_Customizer::class,
		Css\Css::class,
		Init\Init_Theme::class,
		Custom\Sidebars\Sidebars::class,
		Custom\Image\Size::class,
		Nav_Menu\Register_Nav_Menu_Edit::class,

		// This is the class that build the page
		Builders\Director::class,
	],
];