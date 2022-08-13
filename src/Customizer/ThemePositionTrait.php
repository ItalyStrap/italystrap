<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

trait ThemePositionTrait {

	private function getAllThemePosition(): array {
		return (array)$this->dispatcher->filter( 'italystrap_theme_positions', [] );
	}
}
