<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigColorSectionProvider {

	public const BG_COLOR = 'background_color';
	public const HEADER_COLOR = 'header_textcolor';
	public const LINK_COLOR = 'link_textcolor';
	public const HX_COLOR = 'hx_textcolor';

	public function __invoke(): iterable {
		yield self::BG_COLOR => '';// Set by WordPress.
		yield self::HEADER_COLOR => '';// Set by WordPress.
		yield self::LINK_COLOR => '';
		yield self::HX_COLOR => '';
	}
}
