<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Theme\Registrable;

final class ConfigCurrentTemplateSubscriber implements Registrable, SubscriberInterface {

	const TEMPLATE_FILE_NAME = 'current_template_file';
	const TEMPLATE_FILE_SLUG = 'current_template_slug';

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

		$this->config->add( self::TEMPLATE_FILE_NAME, $base_name );
		$this->config->add( self::TEMPLATE_FILE_SLUG, $slug );

		return $current_template->__toString();
	}
}
