<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 05/03/2019
 * Time: 07:58
 */

namespace ItalyStrap\Template;


interface Finder_Interface
{
	/**
	 * @return mixed
	 */
	public function getRealPath( $templates );
}