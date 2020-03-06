<?php
declare(strict_types=1);

namespace ItalyStrap\Builders;

interface Builder_Interface {

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function set_injector( \Auryn\Injector $injector );

	/**
	 * Build the page
	 *
	 * @throws \Exception
	 */
	public function build();
}
