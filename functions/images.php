<?php
/**
 * For file size @see image_size.php
 *
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
 *
 * @TODO In futuro fare refactoring di questo file
 * @package ItalyStrap
 */
declare(strict_types=1);
if ( ! function_exists( 'italystrap_get_the_custom_image_url' ) ) {
	/**
	 * Get the custom image URL from customizer
	 *
	 * @param  string $key     Custom image array's key name
	 *                         default_image
	 *                         logo
	 *                         default_404.
	 * @param  string $default SRC of default image url.
	 * @return string          Return the image URL if exist
	 */
	function italystrap_get_the_custom_image_url( $key = null, $default = null ) {

		if ( ! $key ) {
			return '';
		}

		global $theme_mods;

		if ( empty( $theme_mods[ $key ] ) ) {
			return '';
		}

		if ( is_numeric( $theme_mods[ $key ] ) ) {
			$image = wp_get_attachment_url( $theme_mods[ $key ] );
		} elseif ( $theme_mods[ $key ] ) {
			$image = $theme_mods[ $key ];
		} else { $image = $default;
		}

		return esc_url( $image );
	}
}

if ( ! function_exists( 'italystrap_thumb_url' ) ) {
	/**
	 * Echo image url, if exist get the post image, else get the default image
	 *
	 * @return string Echo image url
	 */
	function italystrap_thumb_url() {

		if ( has_post_thumbnail() ) {

			$post_thumbnail_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
			echo $image_attributes[0];

		} else {
			echo italystrap_get_the_custom_image_url( 'default_image' );
		}

		return '';
	}
}

if ( ! function_exists( 'italystrap_logo' ) ) {
	/**
	 * Get the logo url
	 */
	function italystrap_logo() {
		echo italystrap_get_the_custom_image_url( 'logo', TEMPLATEURL . '/img/italystrap-logo.jpg' );
	}
}


if ( ! function_exists( 'estraiUrlsGravatar' ) ) {
	/**
	 * Get the Gravatar URL
	 * funzione per estrapolare le url da gravatar
	 *
	 * @param  string $url [description]
	 * @return string      Return Gravatar url
	 */
	function estraiUrlsGravatar( $url ) {

		$url_pulito = substr( $url, 17, - 56 );
		return $url_pulito;
	}
}

if ( ! function_exists( 'italystrap_get_avatar_url' ) ) {
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
	function italystrap_get_avatar_url( $email ) {

		if ( ! $email ) {
			return '';
		}

		$hash = md5( strtolower( trim( $email ) ) );
		return 'http://gravatar.com/avatar/' . $hash;

	}
}

if ( ! function_exists( 'italystrap_get_avatar' ) ) {
	/**
	 * Retrieve the avatar for a user who provided a user ID or email address.
	 *
	 * @since 1.8.7
	 *
	 * @param int|string|object $id_or_email A user ID,  email address, or comment object
	 * @param int               $size Size of the avatar image
	 * @param string            $default URL to a default image to use if no avatar is available
	 * @param string            $alt Alternative text to use in image tag. Defaults to blank
	 * @param string            $class Add custom CSS class for avatar
	 * @return string <img> tag for the user's avatar
	 */
	function italystrap_get_avatar( $id_or_email, $size = '96', $default = '', $alt = false, $class = '' ) {

		$avatar = get_avatar( $id_or_email, $size, $default, $alt );

		if ( $class ) {
			$avatar = str_replace( 'photo', "photo $class" , $avatar );
		}

		return $avatar;
	}
}

if ( ! function_exists( 'italystrap_add_image_class' ) ) {
	/**
	 *
	 * Add img-responsive css class when new images are upload
	 * For old image install Search regex plugin and replace '<img class="' to '<img class="img-responsive ' without apostrophe mark ;-)
	 */
	function italystrap_add_image_class( $class ) {
		$class .= ' img-responsive';
		return $class;
	}
	add_filter( 'get_image_tag_class','italystrap_add_image_class' );
}

/**
 * For other image class see cleanup.php from line 142 to line 189
 * There is thumbnail class for attachment and img-responsive and thumbnail for figure and figure caption
 */

if ( ! function_exists( 'italystrap_get_404_image' ) ) {
	/**
	 * Get the image for 404 page
	 * The image is set in the customizer
	 *
	 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
	 * @see https://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
	 * @return string Return html image string for 404 page
	 */
	function italystrap_get_404_image( $class = '' ) {

		global $theme_mods;

		if ( 'show' !== $theme_mods['404_show_image'] ) {
			return;
		}

		/**
		 * Back compat with the old setting name
		 */
		$default_image = TEMPLATEURL . 'assets/img/404.png';

		if ( empty( $theme_mods['404_image'] ) ) {
			$theme_mods['404_image'] = $theme_mods['default_404'];
			remove_theme_mod( 'default_404' ); // Remove the old value from database
		}

		$image_404_url = $default_image;
		$width = absint( $theme_mods['content_width'] );
		$height = '';
		$alt = __( 'Image for 404 page', 'italystrap' ) . ' ' . esc_attr( GET_BLOGINFO_NAME );

		if ( is_numeric( $theme_mods['404_image'] ) ) {

			$size = apply_filters( 'italystrap_404_image_size', $theme_mods['post_thumbnail_size'] );

			$id = (int) $theme_mods['404_image'];
			$meta = wp_get_attachment_image_src( $id, $size );
			$image_404_url = $meta[0];
			$width = esc_attr( $meta[1] );
			$height = esc_attr( $meta[2] );
		}

		$attr = array(
			'class'		=>	$class,
			'width'		=>	empty( $width ) ? '' : $width . 'px',
			'height'	=>	empty( $height ) ? '' : $height . 'px',
			'src'		=>	$image_404_url,
			'alt'		=>	$alt,

		);

		$html = sprintf(
			'<img %s>',
			\ItalyStrap\Core\get_attr( '', $attr )
		);

		$html = apply_filters( 'italystrap_404_image_html', $html );

		/**
		 * If is active ItalyStrap plugin
		 */
		if ( function_exists( 'italystrap_apply_lazyload' ) ) {
			return italystrap_get_apply_lazyload( $html );
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'italystrap_get_ID_image_from_url' ) ) {
	/**
	 * Get the attachment ID from image url
	 *
	 * @todo Get the ID from image resized (eg: thumbnail)
	 *
	 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
	 * @param  string $url The url of image
	 * @return int         The ID of the image
	 */
	function italystrap_get_ID_image_from_url( $url ) {

		global $wpdb;

		$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM %s WHERE guid=%s", [ $wpdb->posts, $url ] ) );

		return absint( $id );

	}
}

if ( ! function_exists( 'italystrap_get_the_post_thumbnail' ) ) {
	/**
	 * Questa funzione pesca l'immagine correlata all'articolo (attachment) e la visualizza
	 * se non c'è visualizza un'immagine di default inserita nella cartella img del tema
	 *
	 * Viene inserita l'ultima immagine associata ad un post, per visualizzarne un'altra
	 * bisogna cancellare la prima e inserire la nuova.
	 *
	 * @todo In questa funzione creare una if per stampare o ritornare il codice, per farlo aggiungere un parametro alla funzione o all'array, esempio:
	 * if (true)
	 *    return
	 * else
	 *    echo
	 *
	 * @todo Interessante funzionalità potrebbe essere quella di avere più immagini di default variabili.
	 *
	 * @param $postID ID del post nel loop
	 * @param $size Il nome della thumb dichiarate in add_image_size()
	 * @param $default_width Deve essere un numero intero corrispondente alla larghezza dell'immagine di default
	 * @param $default_height Deve essere un numero intero corrispondente all'altezza' dell'immagine di default
	 * @return string
	 */
	function italystrap_get_the_post_thumbnail( $postID = null, $size = 'post-thumbnail', $attr = array(), $default_width = 0, $default_height = 0, $default_image = '' ) {

		/**
		 * If has feautured image return that
		 */
		if ( has_post_thumbnail() ) {
			return get_the_post_thumbnail( $postID, $size, $attr );
		}

		$postID = ( null === $postID ) ? get_the_ID() : $postID;

		/**
		 * The value to return
		 *
		 * @var string
		 */
		$image_html = '';

		/**
		 * Array arguments for get_posts()
		 *
		 * @var array
		 */
		$args = array(
			'numberposts' => 1,
			'post_parent' => $postID,
			'post_type' => 'attachment',
			// 'post_status' => null,
			'post_mime_type' => 'image',
			'order' => 'ASC',
		);

		/**
		 * Get the post object
		 *
		 * @var object
		 */
		$first_images = get_posts( $args );

		/**
		 * Text alternative for image
		 *
		 * @var string
		 */
		$alt = ( empty( $first_images[0]->post_title ) ) ? get_the_title() : $first_images[0]->post_title ;

		/**
		 * Set the default alt value if $attr['alt'] is empty
		 */
		$attr['alt'] = ( ! empty( $attr['alt'] ) ) ? $attr['alt'] : $alt;

		/**
		 * Set the default class value if $attr['class'] is empty
		 */
		$attr['class'] = ( ! empty( $attr['class'] ) ) ? $attr['class'] : 'center-block img-responsive';

		$default_image = italystrap_get_the_custom_image_url( 'default_image' );
		/**
		 * Fallback image
		 *
		 * @var string
		 */
		$default_image = '<img src="' . $default_image . '" width="' . $default_width . 'px" height="' . $default_height . 'px" alt="' . $attr['alt'] . '" class="' . $attr['class'] . '">';

		/**
		 * Set the default image
		 *
		 * @var string
		 */
		$image_html = $default_image;

		if ( $first_images ) {

			/**
			 * Get the attachment value
			 *
			 * @var array
			 */
			$image_attributes = wp_get_attachment_image_src( $first_images[0]->ID, $size );

			/**
			 * $default_width imposta la larghezza di default dell'immagine
			 * Se l'immagine nel post è più piccola del 10% la mostra altrimenti no.
			 */
			if ( $image_attributes[1] >= $default_width / 1.1 ) {
				$image_html = '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" alt="' . $attr['alt'] . '" class="' . $attr['class'] . '">'; }
		}

		if ( function_exists( 'italystrap_get_apply_lazyload' ) ) {
			$image_html = italystrap_get_apply_lazyload( $image_html ); }

		return $image_html;

	}
}

if ( ! function_exists( 'italystrap_the_post_thumbnail' ) ) {
	function italystrap_the_post_thumbnail( $size = 'post-thumbnail', $attr = '', $default_width = '', $default_height = '' ) {
		echo italystrap_get_the_post_thumbnail( null, $size, $attr,  $default_width, $default_height );
	}
}


/*
* Display Image from the_post_thumbnail or the first image of a post else display a default Image
* Chose the size from "thumbnail", "medium", "large", "full" or your own defined size using filters.
* USAGE: <?php echo my_image_display(); ?>
*/

// function my_image_display($size = 'article-thumb') {
// global $pathchild;
// if (has_post_thumbnail()) {
// $image_id = get_post_thumbnail_id();
// $image_url = wp_get_attachment_image_src($image_id, $size);
// $image_url = $image_url[0];
// } else {
// global $post, $posts;
// $image_url = '';
// ob_start();
// ob_end_clean();
// $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
// $image_url = $matches [1] [0];
// Defines a default image
// if(empty($image_url)){
// $image_url = $pathchild . "/img/default.jpg";
// }
// }
// return $image_url;
// }
/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @see https://developer.wordpress.org/reference/functions/img_caption_shortcode/
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */

if ( ! function_exists( 'italystrap_new_caption_style' ) ) {
	/**
	 * Filters the default caption shortcode output.
	 *
	 * If the filtered output isn't empty, it will be used instead of generating
	 * the default caption template.
	 *
	 * @since 2.6.0
	 *
	 * @see img_caption_shortcode()
	 *
	 * @param string $output  The caption output. Default empty.
	 * @param array  $attr    Attributes of the caption shortcode.
	 * @param string $content The image element, possibly wrapped in a hyperlink.
	 */
	function italystrap_new_caption_style( $output, array $attr, $content ) {

		if ( is_feed() ) {
			return $output;
		}

		if ( ! isset( $attr ) ) {
			return $output;
		}

		$defaults = array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => '',
			'class'   => '',
		);

		$attr = shortcode_atts( $defaults, $attr, 'caption' );

		$attr['width'] = (int) $attr['width'];

		/**
		 * If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
		 */
		if ( $attr['width'] < 1 || empty( $attr['caption'] ) ) {
			return $content;
		}

		$figure_attr = array(
			'class'	=> sprintf(
				'img-responsive wp-caption %s %s',
				esc_attr( $attr['align'] ),
				esc_attr( $attr['class'] )
			),
			'style'	=> sprintf(
				'width: %spx',
				$attr['width']
			),
		);

		if ( ! empty( $attr['id'] ) ) {
			$figure_attr['id'] = sprintf(
				'id="%s"',
				esc_attr( $attr['id'] )
			);
		}

		$html_figure_attributes = ItalyStrap\Core\get_attr( 'figure_img_caption_shortcode', $figure_attr );

		$output  = '<figure ' . $html_figure_attributes .'>';
		$output .= do_shortcode( $content );

		$figcaption_attr = array(
			'class'	=> 'caption wp-caption-text',
		);

		$html_figcaption_attributes = ItalyStrap\Core\get_attr( 'figcaption_img_caption_shortcode', $figcaption_attr );

		$output .= '<figcaption ' . $html_figcaption_attributes . '>' . $attr['caption'] . '</figcaption></figure>';

		return $output;




		$html5 = current_theme_supports( 'html5', 'caption' );
		// HTML5 captions never added the extra 10px to the image width
		$width = $html5 ? $atts['width'] : ( 10 + $atts['width'] );

		/**
		 * Filters the width of an image's caption.
		 *
		 * By default, the caption is 10 pixels greater than the width of the image,
		 * to prevent post content from running up against a floated image.
		 *
		 * @since 3.7.0
		 *
		 * @see img_caption_shortcode()
		 *
		 * @param int    $width    Width of the caption in pixels. To remove this inline style,
		 *                         return zero.
		 * @param array  $atts     Attributes of the caption shortcode.
		 * @param string $content  The image element, possibly wrapped in a hyperlink.
		 */
		$caption_width = apply_filters( 'img_caption_shortcode_width', $width, $atts, $content );

		$style = '';
		if ( $caption_width ) {
			$style = 'style="width: ' . (int) $caption_width . 'px" ';
		}

		if ( $html5 ) {
			$html = '<figure ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
				. do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
		} else {
			$html = '<div ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
				. do_shortcode( $content ) . '<p class="wp-caption-text">' . $atts['caption'] . '</p></div>';
		}

		return $html;


	}
// add_filter( 'img_caption_shortcode', 'italystrap_new_caption_style', 10, 3 );
}
