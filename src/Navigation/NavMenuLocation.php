<?php
declare(strict_types=1);

namespace ItalyStrap\Navigation;

class NavMenuLocation implements NavMenuLocationInterface
{

	public function has( string $location ): bool {
		return (bool)\has_nav_menu( $location );
	}

	public function register( string $location, string $description ): void {
		\register_nav_menu( $location, $description );
	}

	public function registerMany( array $locations ): void {
		\register_nav_menus( $locations );
	}

	public function unregister( string $location ): bool {
		return \unregister_nav_menu( $location );
	}

	public function toArray(): array {
		return (array)get_registered_nav_menus();
	}
}
