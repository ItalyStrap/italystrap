<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Event\SubscriberInterface;

class CustomizerAssetsSubscriber implements SubscriberInterface {

	private ConfigInterface $config;

	public function getSubscribedEvents(): iterable {
		return [
			'customize_preview_init' => 'enqueueScriptOnLivePreview',
			'customize_controls_enqueue_scripts' => 'enqueueCustomizeControl',
		];
	}

	public function __construct(
		ConfigInterface $config
	) {
		$this->config = $config;
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 */
	public function enqueueScriptOnLivePreview(): void {
		\wp_enqueue_script(
			self::class,
			$this->config->get( ConfigThemeProvider::TEMPLATE_DIR_URI ) . '/src/Customizer/js/src/theme-customizer.js',
			['jquery', 'customize-preview'],
			null,
			true
		);
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings.
	 */
	public function enqueueCustomizeControl(): void {
		\wp_enqueue_script(
			self::class,
			$this->config->get( ConfigThemeProvider::TEMPLATE_DIR_URI )
			. '/src/Customizer/js/src/customize-controls.js',
			['jquery'],
			null,
			true
		);
	}
}
