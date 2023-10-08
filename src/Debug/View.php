<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\Debug;

use ItalyStrap\View\ViewInterface;

final class View implements ViewInterface {

    private ViewInterface $view;

    public function __construct(ViewInterface $view) {
		$this->view = $view;
	}

	public function render($slugs, $data = []): string {

		if ($slugs === 'sidebar') {
			return $this->view->render( $slugs, $data );
		}

		$slugs = (array)$slugs;
		$prefix = "<div style='padding-block: 0.5rem; background:#ddd;'>START DEBUG <small><i>{$slugs[0]}</i></small></div>";
		$suffix = "<div style='padding-block: 0.5rem; background:#ddd;'>END DEBUG <small><i>{$slugs[0]}</i></small></div>";

		$content = \sprintf(
			'%s%s%s',
			$prefix ?? '',
			$this->view->render( $slugs, $data ),
			$suffix ?? ''
		);

		return $content;
	}
}
