<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use \ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\HTML\Tag;

/**
 * Class for registering sidebars in template
 * There are a standard sidebar and 4 footer dynamic sidebars
 * @package ItalyStrap\Theme
 */
class SidebarsSubscriber implements Registrable, SubscriberInterface {

	const NAME = 'name';
	const ID = 'id';
	const DESCRIPTION = 'description';
	const CLASS_NAME = 'class';
	const BEFORE_WIDGET = 'before_widget';
	const AFTER_WIDGET = 'after_widget';
	const BEFORE_TITLE = 'before_title';
	const AFTER_TITLE = 'after_title';
	/**
	 * @var Tag
	 */
	private $tag;

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'widgets_init'			=> static::REGISTER_CB;
	}

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Init sidebars registration
	 * @param Config $config
	 * @param Tag $tag
	 */
	public function __construct( Config $config, Tag $tag ) {
		$this->config = $config;
		$this->tag = $tag;
	}

	/**
	 * @inheritDoc
	 */
	public function register() {
		foreach ( $this->config as $sidebar ) {
			\register_sidebar( $this->defaultSidebarConfig( $sidebar ) );
		}
	}

	/**
	 * @param array $sidebar
	 * @return array
	 */
	private function defaultSidebarConfig( array $sidebar ) : array {

		$widget_context = $sidebar['id'] . '-widget';
		$title_context = $sidebar['id'] . '-title';

		$defaults = [
			self::NAME			=> '',
			self::ID			=> '',
			self::DESCRIPTION	=> '',
			self::CLASS_NAME	=> '',
			self::BEFORE_WIDGET	=> $this->tag->open( $widget_context, 'div', ['id' => '%1$s', 'class' => 'widget %2$s'] ),
			self::AFTER_WIDGET	=> $this->tag->close( $widget_context ),
			self::BEFORE_TITLE	=> $this->tag->open( $title_context, 'h3', [ 'class' => 'widget-title' ] ),
			self::AFTER_TITLE	=> $this->tag->close( $title_context ),
		];

		return \array_merge( $defaults, $sidebar );
	}
}
