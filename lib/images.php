<?php
$defaultimage = $path . '/img/ItalyStrap.jpg';

function italystrap_thumb_url(){

	global $defaultimage;
	if ( has_post_thumbnail() ) {
	$post_thumbnail_id = get_post_thumbnail_id();
	$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	echo $image_attributes[0]; 
	
	} else echo $defaultimage;
}

function italystrap_logo(){

	global $defaultimage;
	return $defaultimage;
}

//funzione per estrapolare le url da gravatar
function estraiUrlsGravatar($url){

	$url_pulito = substr($url,17,-56);
	return $url_pulito; 
}

/**
 * Retrieve the avatar url
 *
 * @since 1.8.7
 *
 * @link http://wordpress.stackexchange.com/questions/59442/how-do-i-get-the-avatar-url-instead-of-an-html-img-tag-when-using-get-avatar
 *
 * @param string $email email address of Author or Author comment
 * @return string Avatar url
 */
function italystrap_get_avatar_url( $email ){
    $hash = md5( strtolower( trim ( $email ) ) );
    return 'http://gravatar.com/avatar/' . $hash;	
}

/**
 * Retrieve the avatar for a user who provided a user ID or email address.
 *
 * @since 1.8.7
 *
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @param int $size Size of the avatar image
 * @param string $default URL to a default image to use if no avatar is available
 * @param string $alt Alternative text to use in image tag. Defaults to blank
 * @param string $class Add custom CSS class for avatar
 * @return string <img> tag for the user's avatar
 */
function italystrap_get_avatar(  $id_or_email, $size = '96', $default = '', $alt = false, $class = '' ){

	$avatar = get_avatar( $id_or_email, $size, $default, $alt );
	if ($class) {
		$avatar = str_replace('photo', "photo $class" , $avatar);
	}
	return $avatar;
}

/**
 *
 * Add img-responsive css class when new images are upload
 * For old image install Search regex plugin and replace '<img class="' to '<img class="img-responsive ' without apostrophe mark ;-)
 */
function italystrap_add_image_class($class){
	$class .= ' img-responsive';
	return $class;
}
add_filter('get_image_tag_class','italystrap_add_image_class');

/**
 * For other image class see cleanup.php from line 142 to line 189
 * There is thumbnail class for attachment and img-responsive and thumbnail for figure and figure caption
 */

/* Aggiungi la favicon al tuo Blog
 * by Roberto Iacono di robertoiacono.it
 */
function ri_wp_favicon(){
	
	global $path;
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $path . '/img/favicon.ico" />';
}
add_action('wp_head', 'ri_wp_favicon');
?>