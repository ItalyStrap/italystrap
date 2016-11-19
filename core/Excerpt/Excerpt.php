<?php
/**
 * Excerpt API class.
 *
 * This class manage the output of the excerpt and read more link.
 *
 * @link www.italystrap-com
 * @since 3.x.x
 *
 * @package ItalyStrap\Core\Excerpt
 */

namespace ItalyStrap\Core\Excerpt;

/**
 * New Class to set excerpt lenght and show "more link"
 * @link http://stackoverflow.com/questions/10081129/why-cant-i-override-wps-excerpt-more-filter-via-my-child-theme-functions
 *
 * Codex link:
 * @link http://codex.wordpress.org/Excerpt
 * @link http://codex.wordpress.org/Customizing_the_Read_More
 *
 * The quicktag <!--more--> doesn't work with the_excerpt() and get_the_excerpt(),
 * it works only with the_content and get_the_content
 * Use the box excerpt inside admin panel
 */
class Excerpt {

	/**
	 * Theme settings
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * Init the class
	 *
	 * @param $theme_mods $argument [description].
	 */
	function __construct( array $theme_mods = array() ) {

		$this->theme_mods = $theme_mods;
	}

	/**
	 * Init the add filters
	 */
	public function excerpt_more_function(){

		add_filter( 'get_the_excerpt', array( $this, 'custom_excerpt_more') );
		add_filter( 'excerpt_more', array( $this, 'read_more_link') );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length') );

	}

	/**
	 * Escerpt read more link function
	 *
	 * @hoocked excerpt_more - 10
	 *
	 * @return string Return link to post in read more.
	 */
	public function read_more_link() {

			global $post;

			/**
			 * CSS class for read more link. Default 'none'.
			 *
			 * @var string
			 */
			$class = apply_filters( 'italystrap_read_more_class', $this->theme_mods['read_more_class'] );

			return sprintf(
				/**
				 * Default ' <a href="%1$s" class="%2$s">... %3$s</a>'.
				 */
				$this->theme_mods['read_more_link'],
				get_permalink( $post->ID ),
				$class,
				__( 'Read more', 'italystrap' )
			);
	}

	/**
	 * Function to override
	 * @param  string $output Get excerpt output.
	 *
	 * @hoocked get_the_excerpt - 10
	 * @see ItalyStrap\Core\Excerpt\Excerpt::read_more_link()
	 *
	 * @return string         Return output with read more link
	 */
	public function custom_excerpt_more( $output ) {

			if ( has_excerpt() && ! is_attachment() ) {
				$output .= $this->read_more_link();
			}

			return $output;
	}

	/**
	 * Excerpt lenght function
	 * @param  int $length Get the defautl words number.
	 *
	 * @hoocked excerpt_length - 10
	 *
	 * @return int         Return words numer for excerpt
	 */
	public function excerpt_length( $length ) {

			if ( is_home() || is_front_page() || is_archive() ) {
				$length = $this->theme_mods['excerpt_length'];
			}

			return $length;
	}
}
