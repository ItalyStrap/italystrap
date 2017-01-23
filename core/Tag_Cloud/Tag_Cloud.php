<?php
/**
 * Tag_Cloud API
 *
 * This class add some CSS class to the tag_cloud widget.
 *
 * Initially forked from https://github.com/320press/wordpress-bootstrap
 *
 * @see  https://developer.wordpress.org/reference/functions/wp_tag_cloud/
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Tag_Cloud;

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Tag_Cloud
 */
class Tag_Cloud implements Subscriber_Interface {


	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'widget_tag_cloud_args'	=> 'widget_tag_cloud_args',
			'wp_tag_cloud'			=> array(
				'function_to_add'	=> 'filter',
				'accepted_args'		=> 2,
			),
		);
	}

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	private $defaults = array(
		'smallest'	=> 8,
		'largest'	=> 22,
		'unit'		=> 'pt',
		'number'	=> 45,
		'format'	=> 'flat',
		'separator'	=> "\n",
		'orderby'	=> 'name',
		'order'		=> 'ASC',
		'exclude'	=> '',
		'include'	=> '',
		'link'		=> 'view',
		'taxonomy'	=> 'post_tag',
		'post_type'	=> '',
		'echo'		=> true
	);

	/**
	 * Filters the taxonomy used in the Tag Cloud widget.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/widget_tag_cloud_args/
	 *
	 * @param  array $args Args used for the tag cloud widget.
	 *
	 * @return array       Return the new array
	 */
	public function widget_tag_cloud_args( $args ) {

		$args['number'] = 20; // show less tags
		$args['largest'] = 0.7; // make largest and smallest the same - i don't like the varying font-size look
		$args['smallest'] = 0.7;
		$args['unit'] = 'em';

		return $args;
	}

	/**
	 * Filters tag clould output so that it can be styled by CSS.
	 *
	 * @param  string $return HTML output of the tag cloud.
	 *
	 * @return string         HTML output of the tag cloud.
	 */
	function add_css_class_to_tags( $return ) {

		$output = array();

		$tags = explode( '</a>', $return );

		foreach( $tags as $tag ) {
			$output[] = str_replace( '\'tag-', '\'label label-default tag-', $tag );
		}

		$return = implode( '</a>', $output );

		return $return;
	}

	/**
	 * Filters the tag cloud output.
	 *
	 * @param  string $return HTML output of the tag cloud.
	 * @param  array  $args   An array of tag cloud arguments.
	 *
	 * @return string         HTML output of the tag cloud.
	 */
	function filter( $return, $args ) {
		return $this->add_css_class_to_tags( $return );
	}
}
