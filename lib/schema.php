<?php
/**
 * Display post description for Open Graph and Twitter card
 * 
 * @return string A description text of post
 *
 * @todo Sanitize $excerpt http://codex.wordpress.org/Function_Reference/sanitize_text_field
 */
function italystrap_open_graph_desc(){

	global $post;

	if ( function_exists('aioseop_load_modules') ) {

		$excerpt = get_post_meta($post->ID, '_aioseop_description', true);

	}else if ( class_exists('WPSEO_Meta') ) {

		$excerpt = WPSEO_Meta::get_value('metadesc');

	}else if ( $post->post_excerpt ) {

		$excerpt = trim(str_replace(array("\n", "\r", "\t"), ' ', substr( strip_tags( $post->post_excerpt ), 0, 200 ) ) );

	}else{

		$excerpt = trim(str_replace(array("\n", "\r", "\t", "[", "]", "\""), ' ', substr( strip_tags( $post->post_content ), 0, 200 ) ) ) . ' ...';

	}

	echo $excerpt;
}

/**
 * Get the number of words in post content
 * Use in loop
 *
 * @since 2.1.0
 * 
 * @return integer Get the number of words in post content.
 */
function italystrap_get_words_count(){

	/**
	 * Number of total words in content
	 * @var integer
	 */
    return str_word_count( get_the_content() );

}

/**
 * Add metatag for Schema.org itemprops timeRequired and wordCount
 *
 * @link http://schema.org/Article
 *
 * @since 1.0.0
 * 
 * @return string The meta tags with itemprops timeRequired and wordCount.
 */
function italystrap_ttr_wc( $words_per_minute = NULL ){

	/**
	 * Number of total words in content
	 * @var integer
	 */
    $word_count = italystrap_get_words_count();

    /**
     * Number of words per minute
     * @var integer
     */
    if ( !$words_per_minute )
    	$words_per_minute = 150;

	/**
	 * Get Estimated time to read
	 */
	$minutes = floor( $word_count / $words_per_minute);
	$seconds = floor( ($word_count / ($words_per_minute / 60) ) - ( $minutes * 60 ) );
	
	/**
	 * If less than a minute
	 */
	if( $minutes < 1 )
		$estimated_time = 'PT1M';
	
	/**
	 * If more than a minute
	 */
	if( $minutes >= 1 )
		if( $seconds > 0 )
			$estimated_time = 'PT' . $minutes . 'M' . $seconds . 'S';
		else
			$estimated_time = 'PT' . $minutes . 'M';
	
	$ttr_wc = '<meta  itemprop="timeRequired" content="' . $estimated_time . '"/>';

	/**
	 * Display wordCount only in singular
	 */
	if ( is_singular() )
		$ttr_wc .= '<meta  itemprop="wordCount" content="' . $word_count . '"/>';

	return $ttr_wc;
}

/**
 * Beta functions for FB Open Graph and Twitter cards
 * @return string Return the FB & TW meta tags
 */
function italystrap_add_fb_tw_meta_tags(){

	get_template_part( 'lib/facebook_opengraph' );
	get_template_part( 'lib/twitter_card' );

}
add_action('wp_head', 'italystrap_add_fb_tw_meta_tags', 7);