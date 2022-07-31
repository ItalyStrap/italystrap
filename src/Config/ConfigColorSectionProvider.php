<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigColorSectionProvider {

	const BG_COLOR = 'background_color';
	const HEADER_COLOR = 'header_textcolor';
	const LINK_COLOR = 'link_textcolor';
	const HX_COLOR = 'hx_textcolor';

	public function __invoke(): iterable {
		yield self::BG_COLOR => '';// Set by WordPress.
		yield self::HEADER_COLOR => '';// Set by WordPress.
		yield self::LINK_COLOR => '';
		yield self::HX_COLOR => '';
	}
}
