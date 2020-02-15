<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 15:14
 */
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
