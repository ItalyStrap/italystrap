<?php

namespace ItalyStrap\HTML;

/**
 * @see the function call in _init.php file
 */
function filter_attr() {

	try {
		$schema = \ItalyStrap\Config\get_config_file_content( 'schema' );
		$html_attrs = \ItalyStrap\Config\get_config_file_content( 'html_attrs' );

		$config = \ItalyStrap\Config\Config_Factory::make( array_replace_recursive( $schema, $html_attrs ) );

//		\ItalyStrap\HTML\Parse_Attr::$accepted_args = 5;

		$parser =  \ItalyStrap\Factory\get_injector()->make(
			\ItalyStrap\Builders\Parse_Attr::class,
			[ ':config' => $config ]
		);
		$parser->apply();

	} catch ( \Auryn\InjectorException $exception ) {
		echo $exception->getMessage();
	}
}

/**
 * Wrap embedded media as suggested by Readability
 * Add code to Oembed media
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 * Rootstheme function
 * Renamed and modify for new bootstrap class for video embed
 *
 * @since 1.0.0
 * @since 4.0.0 (Refactored)
 *
 * @see WP_Embed::shortcode()
 *
 * @param mixed   $cache   The cached HTML result, stored in post meta.
 * @param string  $url     The attempted embed URL.
 * @param array   $attr    An array of shortcode attributes.
 * @param int     $post_ID Post ID.
 *
 * @return string          Return the new HTML.
 */
function embed_wrap( $cache, $url, $attr, $post_ID ) {

	if ( strpos( $cache, 'class="twitter-tweet"' ) ) {
		return $cache;
	}

	$container_attr = get_attr(
		'embed-responsive',
		[
			'class' => 'entry-content-asset embed-responsive embed-responsive-16by9'
		]
	);

	$ifr_attr = get_attr(
		'embed-responsive-item',
		[
			'class' => 'embed-responsive-item'
		]
	);

	$elements = explode(' ', $cache );

	if ( ! in_array( 'class', $elements, true ) ) {
		array_splice( $elements, 1, 0, trim( $ifr_attr ) );
	}

	return sprintf(
		'<div%s>%s</div>',
		$container_attr,
		implode( ' ', $elements )
	);
}
add_filter( 'embed_oembed_html', __NAMESPACE__ . '\embed_wrap', 10, 4 );
