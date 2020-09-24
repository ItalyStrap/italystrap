<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Brand;

/**
 * Class Logo
 * @package ItalyStrap\Components\Brand
 *
 * ID
 * $this->config->get( 'navbar_logo_image' )
 *
 */
class Logo
{

	/**
	 * Logo constructor.
	 */
	public function __construct() {
	}

	public function render(): string {
		return '<a href="site/url" title="title" rel="home"><span>Brand</span></a>';
	}
}