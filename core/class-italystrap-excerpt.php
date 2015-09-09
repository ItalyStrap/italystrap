<?php
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
class ItalyStrap_Excerpt
{
	
	function __construct(){

		add_action( 'after_setup_theme', array( $this, 'excerpt_more_function' ) );

	}

	/**
	 * Init the add filters
	 * @return void Init
	 */
	public function excerpt_more_function(){

		add_filter( 'get_the_excerpt', array( $this, 'custom_excerpt_more') );
		add_filter( 'excerpt_more', array( $this, 'read_more_link') );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length') );

	}

	/**
	 * Escerpt read more link function
	 * @return string Return link to post in read more.
	 */
	public function read_more_link() {

	    	global $post;

	    	/**
	    	 * CSS class for read more link
	    	 * @var string
	    	 */
	    	$class = apply_filters( 'read_more_class', 'none' );

			return ' <a href="'. get_permalink( $post->ID ) . '" class="' . $class . '">... ' . __( 'Read more', 'ItalyStrap' ) . '</a>';

	}

	/**
	 * Function to override
	 * @param  string $output Get excerpt output
	 * @return string         Return output with read more link
	 */
	public function custom_excerpt_more( $output ) {

	        if ( has_excerpt() && !is_attachment() )
	            $output .= $this->read_more_link();

	        return $output;

	}

	/**
	 * Excerpt lenght function
	 * @param  int $length Get the defautl words number
	 * @return int         Return words numer for excerpt
	 */
	public function excerpt_length( $length ) {

			if ( is_home() || is_front_page() || is_archive() )
				$length = 25;

			return $length;

	}

}
$italystrap_excerpt = new ItalyStrap_Excerpt;