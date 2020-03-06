<?php
/**
 * Assets Interface
 *
 * Handle the CSS and JS regiter and enque
 *
 * @author      hellofromTonya
 * @link        http://hellofromtonya.github.io/Fulcrum/
 * @license     GPL-2.0+
 *
 * @version 0.0.1-alpha
 *
 * @package ItalyStrap\Asset
 */

namespace ItalyStrap\Asset;

interface AssetInterface {

	/**
	 * Checks if an asset has been enqueued
	 *
	 * @return bool
	 */
	public function is_enqueued();

	/**
	 * Register each of the asset (enqueues it)
	 *
	 * @return null
	 */
	public function register();

	/**
	 * De-register each of the asset
	 *
	 * @return null
	 */
	// public function deregister( $handle );
}
