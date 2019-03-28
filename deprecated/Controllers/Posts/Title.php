<?php
/**
 * Title Controller API
 *
 * [Long Description.]
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Components\Contents;

use ItalyStrap\Config\Config_Interface;
use ItalyStrap\Template\View_Interface;

/**
 * Class description
 */
class Title {

	private $config;
	private $view;

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	private $fiew_path = 'posts/parts/title';

	public function __construct( Config_Interface $config, View_Interface $view  ) {
		$this->config = $config;
		$this->view = $view;
	}

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		$template = $this->template_dir . DIRECTORY_SEPARATOR . $this->fiew_path;

		return $this->view->render( $template, $this->data );
	}
}
