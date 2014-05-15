<?php
$defaultimage = $path . '/img/ItalyStrap.jpg';

function italystrap_thumb_url()
{
	global $defaultimage;
	if ( has_post_thumbnail() ) {
	$post_thumbnail_id = get_post_thumbnail_id();
	$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	echo $image_attributes[0]; 
	
	} else echo $defaultimage;
}

function italystrap_logo()
{
	global $defaultimage;
	return $defaultimage;
}

//funzione per estrapolare le url da gravatar
function estraiUrlsGravatar($url)  
{
	$url_pulito = substr($url,17,-56);
	return $url_pulito; 
}

//Add img-rounded and  img-responsive css class
function italystrap_add_image_class($class){
	$class .= ' img-rounded  img-responsive ';
	return $class;
}
add_filter('get_image_tag_class','italystrap_add_image_class');

/* Aggiungi la favicon al tuo Blog
 * by Roberto Iacono di robertoiacono.it
 */
function ri_wp_favicon()
{
	global $path;
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $path . '/img/favicon.ico" />';
}
add_action('wp_head', 'ri_wp_favicon');
?>