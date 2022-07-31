<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

class ConfigColorSection {
	public function __invoke(): array {
		return [
			/**
			 * Color section
			 */
			'background_color'				=> '', // Set by WordPress.
			'header_textcolor'				=> '', // Set by WordPress.
			'link_textcolor'				=> '',
			'hx_textcolor'					=> '',
			self::class						=> self::class,
		];
	}
}
