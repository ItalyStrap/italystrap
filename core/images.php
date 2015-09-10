<?php
/**
 * For file size @see image_size.php
 * @todo Upload default image on switch theme
 *       (da usare invece della fallback
 *       dell'immagine nella cartella img)
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/switch_theme
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/after_switch_theme
 * @link https://wordpress.org/plugins/auto-upload-images/
 *
 * @todo Al momento dalla versione 3.1 ho cambiato solo il path delle varie
 *       immagini prese dal nuovo theme customizer in futuro eventualmente
 *       migliorare queste funzioni in base alle varie situazioni,
 *       per esempio se non ci sono immagini non ritornare nessun valore
 * @todo L'immagine di default dovrebbe anche essere creata per
 *       le misure varie misure impostate
 */

/**
 * Return the defaul image
 * Useful for Opengraph
 * @return string Return url of default image
 */
function italystrap_get_default_image(){

	global $italystrap_theme_mods, $path;

	if ( empty( $italystrap_theme_mods['default_image'] ) )
		return;

	
	if ( is_int( $italystrap_theme_mods['default_image'] ) )
		$default_image = wp_get_attachment_url( $italystrap_theme_mods['default_image'] );
	elseif ( $italystrap_theme_mods['default_image'] )
		$default_image = $italystrap_theme_mods['default_image'];
	else
		$default_image = $path . '/img/italystrap-default-image.png';

	return esc_url( $default_image );

}

/**
 * Echo image url, if exist get the post image, else get the default image
 * @return string Echo image url
 */
function italystrap_thumb_url(){

	if ( has_post_thumbnail() ) {

		$post_thumbnail_id = get_post_thumbnail_id();
		$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		echo $image_attributes[0]; 
	
	}
	else
		echo italystrap_get_default_image();
	
}

/**
 * Get the logo url
 * @return string Return logo url
 */
function italystrap_logo(){

	global $path;

	if ( empty( $italystrap_theme_mods['logo'] ) )
		return;

	if ( is_int( $italystrap_theme_mods['logo'] ) )
		$logo = wp_get_attachment_url( $italystrap_theme_mods['logo'] );
	elseif ( $italystrap_theme_mods['logo'] )
		$logo = $italystrap_theme_mods['logo'];
	else
		$logo = $path . '/img/italystrap-logo.jpg';

	return esc_url( $logo );
}

//funzione per estrapolare le url da gravatar
/**
 * Get the Gravatar URL
 * @param  string $url [description]
 * @return string      Return Gravatar url
 */
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

	if ($class)
		$avatar = str_replace('photo', "photo $class" , $avatar);

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

/**
 * Add a favicons to site
 * @link http://www.robertoiacono.it/aggiungere-favicon-wordpress-come-perche/
 */
function ri_wp_favicon(){
	_deprecated_function( __FUNCTION__, '3.1' );

	$favicon = false;

	if ( $GLOBALS['italystrap_options']['favicon'] )
		$favicon = $GLOBALS['italystrap_options']['favicon'];

	elseif ( is_child_theme() && !$favicon ) {

		global $pathchild;
		$favicon = $pathchild . '/img/favicon.ico';

	} else {

		global $path;
		$favicon = $path . '/img/favicon.ico';

	}

    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon . '" />';
}
// add_action('wp_head', 'ri_wp_favicon');

/**
 * Get the image for 404 page
 * The image is set in the customizer
 * Default /img/404.jpg
 *
 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
 * @see https://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
 * @return string Return html image string for 404 page
 */
function italystrap_get_404_image( $class = '' ){

	global $italystrap_theme_mods;

	if ( empty( $italystrap_theme_mods['default_404'] ) )
		return;

	// $image_404_url = ITALYSTRAP_PARENT_PATH . '/img/404.jpg';
	$image_404_url = $italystrap_theme_mods['default_404'];
	$width = 848;
	$height = 477;
	$alt = __( 'Image for 404 page', 'ItalyStrap' ) . ' ' . esc_attr( GET_BLOGINFO_NAME );

	if ( is_int( $italystrap_theme_mods['default_404'] ) ){

		// global $wpdb;

		// $image_404_url = esc_attr( $italystrap_theme_mods['default_404'] );
		// $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_404_url'";
		// $id = $wpdb->get_var($query);
		// $meta = wp_get_attachment_metadata( $id );var_dump($meta);
		// $width = ( isset( $meta['width'] ) ) ? $meta['width'] : '' ;
		// $height = ( isset( $meta['height'] ) ) ? $meta['height'] : '' ;
		// $alt = trim( strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true) ) );
		$size = apply_filters( '404-image-size', 'article-thumb' );
		$id = $italystrap_theme_mods['default_404'];
		$meta = wp_get_attachment_image_src( $id, $size );
		$image_404_url = $meta[0];
		$width = esc_attr( $meta[1] );
		$height = esc_attr( $meta[2] );

	}

	$html = '<img width="' . $width . 'px" height="' . $height . 'px" src="' . esc_url( $image_404_url ) . '" alt="' . $alt . '" class="' . $class . '">';

	$html = apply_filters( 'italystrap-404-image', $html );

	/**
	 * If is active ItalyStrap plugin
	 */
	if ( function_exists( 'italystrap_apply_lazyload' ) )
		return italystrap_get_apply_lazyload( $html );
	else
		return $html;

}

/**
 * Get the attachment ID from image url
 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
 * @param  string $url The url of image
 * @return int         The ID of the image
 */
function italystrap_get_ID_image_from_url( $url ){

	global $wpdb;

	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$url'";
	$id = $wpdb->get_var( $query );

	return absint( $id );

}