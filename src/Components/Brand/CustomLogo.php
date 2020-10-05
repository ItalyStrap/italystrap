<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Brand;

use ItalyStrap\Event\EventDispatcherInterface;
use function get_custom_logo;
use function strval;

class CustomLogo {

	/**
	 * @var EventDispatcherInterface
	 */
	private $dispatcher;

	/**
	 * CustomLogo constructor.
	 * @param EventDispatcherInterface $dispatcher
	 */
	public function __construct( EventDispatcherInterface $dispatcher ) {
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @var array
	 */
	private $image_attributes = [
		'class'	=> '',
	];

	/**
	 * @var string[]
	 */
	private $default_attributes = [
		'class'	=> '',
	];

	/**
	 * @param array $attr
	 */
	public function withImageAttr( array $attr ) {
		$this->image_attributes = \array_merge( $this->default_attributes, $attr );
	}

	public function render(): string {
		$this->modifyCustomLogoCssClassAttribute();
		$this->modifyCustomLogoOutput();
		return  strval( get_custom_logo() );
	}

	private function modifyCustomLogoCssClassAttribute(): void {
		$this->dispatcher->addListener(
			'get_custom_logo_image_attributes',
			function ( array $custom_logo_attr, int $custom_logo_id, int $blog_id ) {
				$custom_logo_attr = \array_merge( $this->default_attributes, $custom_logo_attr );
				$custom_logo_attr['class'] = $custom_logo_attr['class'] . ' ' . $this->image_attributes['class'];
			//			$custom_logo_attr['itemprop'] = 'image';
				return $custom_logo_attr;
			},
			10,
			3
		);
	}

	private function modifyCustomLogoOutput(): void {
		$this->dispatcher->addListener(
			'get_custom_logo',
			function ( string $html, int $blog_id ) {
				$html = \str_replace('custom-logo-link', 'custom-logo-link navbar-brand', $html);
			//				$html = \str_replace('rel="home"', 'rel="home" itemprop="url"', $html);
				return $html;
			},
			10,
			3
		);
	}
}
