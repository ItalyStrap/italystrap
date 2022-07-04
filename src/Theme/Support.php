<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

class Support {

	public function toArray(): array {
		global $_wp_theme_features;
		return $_wp_theme_features ?? [];
	}

	public function add( string  $feature, ...$args ) {
		return \add_theme_support( ...func_get_args() );
	}

	public function remove( string $feature ) {
		return \remove_theme_support( $feature );
	}

	public function get( string  $feature, ...$args ) {
		return \get_theme_support( ...func_get_args() );
	}

	public function has( string  $feature, ...$args ): bool {
		return \current_theme_supports( ...func_get_args() );
	}
}
