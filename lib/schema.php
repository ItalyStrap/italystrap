<?php
//Funzione per mostrare una description in open graph e twitter card
function italystrap_open_graph_desc(){
	global $post;
	$myposts = get_posts();
		foreach( $myposts as $post ) : setup_postdata( $post );
			$excerpt = substr( strip_tags( get_the_content() ), 4, 200);
		endforeach; wp_reset_query();
	// Codice per All in One Seo pack
	if ( function_exists('aioseop_load_modules')) {
		$post_aioseo_desc = get_post_meta($post->ID, '_aioseop_description', true);
		if($post_aioseo_desc){
		echo stripcslashes($post_aioseo_desc);
		}}
	// Codice per SEO by Yoast
	if ( class_exists('WPSEO_Meta') ){
		echo WPSEO_Meta::get_value('metadesc');
	}
	if ( !function_exists('wpseo_get_value') && !function_exists('aioseop_load_modules')){
		if ( !empty($post->post_excerpt) ){
			echo $post->post_excerpt;
		}else echo $excerpt;
	}
}


//Funzione per http://schema.org/Article: wordCount - timeRequired
function italystrap_ttr_wc(){

	ob_start();
    the_content();
    $content = ob_get_clean();
    $word_count = sizeof(explode(" ", $content));

	$words_per_minute = 150;
	
	// Get Estimated time
	$minutes = floor( $word_count / $words_per_minute);
	$seconds = floor( ($word_count / ($words_per_minute / 60) ) - ( $minutes * 60 ) );
	
	// If less than a minute
	if( $minutes < 1 ) {
		$estimated_time = 'PT1M';
	}
	
	// If more than a minute
	if( $minutes >= 1 ) {
		if( $seconds > 0 ) {
			$estimated_time = 'PT' . $minutes . 'M' . $seconds . 'S';
		} else {
			$estimated_time = 'PT' . $minutes . 'M';
		}
	}
	
	$ttr_wc = '<meta  itemprop="timeRequired" content="' . $estimated_time . '"/>';

	if ( is_singular() ) {
		$ttr_wc .= '<meta  itemprop="wordCount" content="' . $word_count . '"/>';
	}
	return $ttr_wc;
}
?>