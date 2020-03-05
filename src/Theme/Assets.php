<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Event\Manager as Event;

class Assets implements Registrable, SubscriberInterface
{
	/**
	 * @var Asset
	 */
	private $style;
	/**
	 * @var Asset
	 */
	private $script;

	/**
	 * @var array Asset
	 */
	private $assets = [];

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		\array_walk($this->assets, function ( Asset $asset, $key) {
			$asset->register_all();
		});
	}

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): array {
		return [
			'wp_enqueue_scripts'	=> [
				Event::CALLBACK	=> static::CALLBACK,
			],
			'script_loader_src'		=> [
				'function_to_add'	=> 'jquery_local_fallback',
				'priority'			=> 100, // Priorità da testare
				'accepted_args'		=> 2,
			],
			'wp_footer'				=> 'jquery_local_fallback',
		];
	}

	public function withAssets( Asset ...$assets ) {
		$this->assets = \array_merge($assets, $this->assets);
	}

	/**
	 * Print fallback if google CDN is out
	 *
	 * @link http://wordpress.stackexchange.com/a/12450
	 * @link https://github.com/roots/roots/blob/master/lib/scripts.php
	 *
	 * @since 1.0.0
	 *
	 * @param  string $src    jQuery src if true = $add_jquery_fallback.
	 * @param  string $handle Name of handle.
	 * @return string         Return jQuery fallback if true = $add_jquery_fallback
	 */
	function jquery_local_fallback( $src, $handle = null ) {

		static $add_jquery_fallback = false;

		if ( $add_jquery_fallback ) {

			/**
			 * @todo document.write è da sostituire.
			 */
			echo '<script>window.jQuery || document.write(\'<script src="' . TEMPLATEURL . '/js/jquery.min.js"><\/script>\')</script>' . "\n";
			$add_jquery_fallback = false;
		}

		if ( 'jquery' === $handle ) {
			$add_jquery_fallback = true;
		}

		return $src;
	}
}