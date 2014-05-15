<?php 
//Definisco la lunghezza massima excerpt
function custom_excerpt_length( $length ) {
	if ( is_home() || is_front_page() ){
	return 30;}
	else{
	return 50;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 20 );

function new_excerpt_more( $more ) {
	if ( is_home() || is_front_page() ){
	return '';}
	else{
	return ' <a href="'. get_permalink() . '">... Continua a leggere</a>';
	}
}
add_filter('excerpt_more', 'new_excerpt_more');
?>