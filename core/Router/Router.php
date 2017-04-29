<?php
/**
 * Router API
 *
 * ALPHA Version
 *
 * @example
 *
 * In Child Theme
 * add_filter(
 * 	'italystrap_template_include',
 * 	array( new child_TemplateMap(), 'filter_map' )
 * );
 *
 * class child_TemplateMap{
 * 
 * 	public function filter_map( $map ) {
 * 		return array(
 * 			// setup some stuff before content
 * 			'content.php' => array( $this, 'content' ),
 * 			// my custom author template in custom place
 * 			'partials/author-bio.php' => 'partials/authors.php',
 * 			// not found? Show an ad!
 * 			'partials/no-content.php' => 'partials/ads/404.php'
 * 		);
 * 	}
 * 
 * 	public function content( $template ) {
 * 		add_action(
 * 			'italystrap_before_loop',
 * 			array( new child_TemplateAds, 'loop_ad' )
 * 		);
 * 		return $template;
 * 	}
 * }
 * 
 * class child_TemplateAds{
 * 	public function loop_ad() {
 * 		echo '<a href="http://www.italystrap.it/">ItalyStrap</a>';
 * 	}
 * }
 *
 * @credits Luca Tumedei
 * @link https://github.com/lucatume
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Router;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Router Class API
 */
class Router implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked template_include - 99999
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'template_include'	=> array(
				'function_to_add'	=> 'route',
				'priority'			=> 99999,
			),
		);
	}

	/**
	 * Get an array with template name.
	 *
	 * @return array Array with template name
	 */
	public function get_template_include() {
		return apply_filters( 'italystrap_template_include', array() );
	}

	/**
	 * Route method
	 *
	 * @hooked template_include - 99999
	 *
	 * @param  string $template The current template path.
	 *
	 * @return string           The new template path.
	 */
	public function route( $template ) {

		$map = $this->get_template_include();

		if( isset( $map[ CURRENT_TEMPLATE ] ) ) {

			$callback = $map[ CURRENT_TEMPLATE ];

			$template = is_callable( $callback )
				? call_user_func(
					$callback,
					locate_template( CURRENT_TEMPLATE ),
					$this
				)
				: locate_template( $callback );
		}

		return $template;
	}
}
