<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;

final class CurrentTemplateConstantSupportSubscriber implements Registrable, SubscriberInterface {

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'template_include'	=> [
			self::CALLBACK	=> self::REGISTER_CB,
			self::PRIORITY	=> PHP_INT_MAX - 100,
		];
	}

	private ConfigInterface $config;
	private FileInfoFactoryInterface $fileInfoFactory;

	/**
	 * Init sidebars registration
	 */
	public function __construct(
		ConfigInterface $config,
		FileInfoFactoryInterface $fileInfoFactory
	) {
		$this->config = $config;
		$this->fileInfoFactory = $fileInfoFactory;
	}

	public function register( string $current_template = '' ): string {
		$current_template = $this->fileInfoFactory->make( $current_template );
		$base_name = $current_template->getBasename();
		$slug = $current_template->getBasename('.'.$current_template->getExtension());

		define( 'CURRENT_TEMPLATE', $base_name );
		define( 'CURRENT_TEMPLATE_SLUG', $slug );

		$this->config->add(
			'current_template_file',
			$base_name
		);

		$this->config->add(
			'current_template_slug',
			$slug
		);

		return $current_template->__toString();
	}
}
