<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 12:39
 */

namespace ItalyStrap\Builders;


class Director
{
	private $builder;
	public function __construct( Builder_Interface $builder ) {
		$this->builder = $builder;
	}
	public function build() {
		$this->builder->output();
	}
}