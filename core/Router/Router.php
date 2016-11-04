<?php
/**
 * Router API
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
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Router;

/**
 * Router Class API
 */
class Router{

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

			$template = is_callable( $callback ) ?
				call_user_func(
					$callback,
					TEMPLATEPATH . DIRECTORY_SEPARATOR . CURRENT_TEMPLATE,
					$this
				)
				: $callback;
		}

		return $template;
	}
}
