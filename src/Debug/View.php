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
//		d( $slugs, $data );
		return $this->view->render( ...func_get_args() );
	}
}
