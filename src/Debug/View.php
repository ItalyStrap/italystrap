<?php
declare(strict_types=1);

namespace ItalyStrap\Debug;

use ItalyStrap\Config\Config_Interface;
use ItalyStrap\View\ViewInterface;
use function func_get_args;

final class View implements ViewInterface {



	public function __construct( ViewInterface $view ) {
		$this->view = $view;
	}

	/**
	 * @inheritDoc
	 */
	public function render( $slugs, $data = [] ): string {
		$slugs = (array)$slugs;
		$prefix = "<div style='padding-block: 0.5rem; background:#ddd;'>START DEBUG <small><i>{$slugs[0]}</i></small></div>";
		$suffix = "<div style='padding-block: 0.5rem; background:#ddd;'>END DEBUG <small><i>{$slugs[0]}</i></small></div>";

		$content = \sprintf(
			'%s%s%s',
			$prefix,
			$this->view->render( $slugs, $data ),
			$suffix
		);

		return $content;
	}
}
