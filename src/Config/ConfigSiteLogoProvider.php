<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigSiteLogoProvider {

	const CUSTOM_LOGO_ID = 'custom_logo';

	const DISPLAY_NAVBAR_BRAND_IMAGE = 'display_navbar_brand';
	const BRAND_IMAGE_ID = 'navbar_logo_image';
	const BRAND_IMAGE_SIZE = 'navbar_logo_image_size';
	const BRAND_IMAGE_MOBILE = 'navbar_logo_image_mobile';

	public function __invoke(): iterable {
		yield self::DISPLAY_NAVBAR_BRAND_IMAGE => 'display_name';
		yield self::BRAND_IMAGE_ID => 0;
		yield self::BRAND_IMAGE_SIZE => 'navbar-brand-image';
		yield self::BRAND_IMAGE_MOBILE => 0;
	}
}
