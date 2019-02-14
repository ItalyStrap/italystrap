<?php
/**
 * Classes and functions deprecated
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

use \ItalyStrap\Core;
use \ItalyStrap\Navbar\Bootstrap_Nav_Menu;

/**
 * Breadcrumb.
 *
 * @deprecated 2.0.0
 * @deprecated Use new ItalyStrapBreadcrumbs( $defaults );
 * @see ItalyStrapBreadcrumbs( $defaults );
 * require locate_template( '/deprecated/breadcrumb.php' );
 */

/**
 * Sidebar.
 *
 * @deprecated 4.0.0
 * require locate_template( '/deprecated/sidebar.php' );
 */

/**
 * Globals variables for internal use.
 *
 * @deprecated 4.0.0
 * require locate_template( '/deprecated/globals.php' );
 */

/**
 * Function for init load.
 * In this file there are after_setup_theme and $content_width
 *
 * @deprecated 4.0.0
 * require locate_template( '/lib/init.php' );
 */

/**
 * Deprecated new_get_cancel_comment_reply_link
 * require locate_template( '/lib/comment_reply.php' );
 */

/**
 * Walker comments
 * require locate_template( '/lib/comments.php' );
 */

/**
 * Custom fields.
 *
 * @deprecated 4.0.0
 * require locate_template( '/lib/custom_fields.php' );
 */

/**
 * Custom Widget.
 *
 * @deprecated 4.0.0
 * require locate_template( '/lib/widget.php' );
 */

/**
 * Custom excerpt_length and more.
 * Now is in core directory
 *
 * @deprecated 4.0.0
 * require locate_template( '/lib/custom_excerpt.php' );
 */

/**
 * Custom shortcode
 *
 * @deprecated 4.0.0
 * require locate_template( '/lib/custom_shortcode.php' );
 */

/**
 * Class deprecated, use Bootstrap_Nav_Menu instead
 * @deprecated 3.1.0 Class deprecated on 01-11-2015
 */
class wp_bootstrap_navwalker extends Bootstrap_Nav_Menu{

	/**
	 * Deprecated class
	 */
	public function __construct() {

		_deprecated_function( __CLASS__ , '4.0.0', 'Bootstrap_Nav_Menu' );

	}

}

/**
 * Echo the ItalyStrap theme version (parent or child if exist)
 * Used in footer
 *
 * @deprecated 4.0.0
 */
function italystrap_version() {

	_deprecated_function( __FUNCTION__ , '4.0.0', 'Use constant ITALYSTRAP_THEME_VERSION instead.' );

	echo ITALYSTRAP_THEME_VERSION;

}

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function roots_caption($output, $attr, $content) {
  _deprecated_function( __FUNCTION__, '4.0.0', '' );
  if (is_feed()) {
    return $output;
  }

  $defaults = array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => ''
  );

  $attr = shortcode_atts($defaults, $attr);

  // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
  if ($attr['width'] < 1 || empty($attr['caption'])) {
    return $content;
  }

  // Set up the attributes for the caption <figure>
  $attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
  $attributes .= ' class="thumbnail img-responsive wp-caption ' . esc_attr($attr['align']) . '"';
  $attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

  $output  = '<figure' . $attributes .'>';
  $output .= do_shortcode($content);
  $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
  $output .= '</figure>';

  return $output;
}
// add_filter('img_caption_shortcode', 'roots_caption', 10, 3);

/**********************
 * DEPRECATED FUNCTION
 **********************/
/**
 * Retrieve HTML content for new cancel comment reply link with Twitter Botstrap style.
 *
 * @link /wp-includes/comment-template.php
 * @since 1.9.1
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 * @param string $class Optional. Bootstrap button class. Default empty.
 */
function new_get_cancel_comment_reply_link( $text = '', $class = '' ) {

  _deprecated_function( __FUNCTION__, 'ItalyStrap 3.1' );

  if ( empty( $text ) )
    $text = __('Click here to cancel reply.', 'italystrap');

  if ( empty( $class ) )
    $class = 'btn btn-danger btn-xs';

  $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
  $link = esc_html( remove_query_arg('replytocom') ) . '#respond';

  $formatted_link = '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . ' class="' . $class . '">' . $text . '</a>';

  /**
   * Filter the new cancel comment reply link HTML.
   *
   * @since 1.9.1
   *
   * @param string $formatted_link The HTML-formatted cancel comment reply link.
   * @param string $link           New Cancel comment reply link URL.
   * @param string $class          New Cancel comment reply css class.
   * @param string $text           New Cancel comment reply link text.
   */
  return apply_filters( 'new_cancel_comment_reply_link', $formatted_link, $link, $class, $text);
}
/**
 * Display HTML content for new cancel comment reply link.
 *
 * @link /wp-includes/comment-template.php
 * @since 1.9.1
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 * @param string $class Optional. Bootstrap button class. Default empty.
 */
function new_cancel_comment_reply_link($text = '', $class = '' ) {

  echo new_get_cancel_comment_reply_link($text, $class);

}


/**
 * ItalyStrap_custom_comment()
 * @return
 */
function ItalyStrap_custom_comment($comment, $args, $depth){
  $GLOBALS['comment'] = $comment;
  switch ($comment->comment_type) :
  case 'pingback' :
  case 'trackback' : ?>

  <li class="comment media" id="comment-<?php comment_ID(); ?>">
    <div class="media-body">
      <p>
        Pingback: <?php comment_author_link(); ?>
      </p>
    </div><!--/.media-body -->
    <?php
    break;
    default :
                // Proceed with normal comments.
    global $post; ?>


    <div class="<?php if($depth == 1) echo 'col-md-12'; else echo 'col-md-11 col-md-offset-1'; ?>">
      <div class="row <?php if ($comment->user_id === $post->post_author) { echo 'bg-color-author';} ?>"itemscope itemtype="https://schema.org/Comment">
        <div class="col-md-2"><?php echo get_avatar($comment, '92') ?></div>
        <div class="col-md-10">
          <ul class="list-inline">
            <li>
              <h4 class="media-heading">
                <a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="https://schema.org/Person"><?php echo get_comment_author() ?><meta itemprop="image" content="<?php  $thumbnailUrl = get_avatar($comment); echo estraiUrlsGravatar($thumbnailUrl);?>"/></span></a>
                <?php
                /**
                 * If current post author is also comment author,
                 * make it known visually.
                 * @var [type]
                 */
                printf(
                ($comment->user_id === $post->post_author) ? '<span class="label label-danger"> ' . __('The Boss :-)', 'italystrap') . '</span> ' : ''); ?>
              </h4>

            </li>
            <li><time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time></li>
            <?php edit_comment_link(__('Edit','italystrap'),'<span class="btn btn-sm btn-warning pull-right"><i class="glyphicon glyphicon-pencil"></i> ','</span>') ?>
          </ul>

          <p itemprop="text"><?php echo get_comment_text($comment); ?></p>
          <?php if ($comment->comment_approved == '0') : ?>
          <span  class="alert alert-success">Il tuo commento &egrave; in attesa di moderazione.</span>
        <?php endif; ?>

        <p class="reply btn btn-small btn-success pull-right">
          <?php 
          comment_reply_link( 
            array_merge(
              $args, 
              array(
                'reply_text' => __('Reply <i class="glyphicon glyphicon-arrow-down"></i>', 'italystrap'),
                'depth'      => $depth,
                'max_depth'  => $args['max_depth'],
                'class'      => 'btn',
                )
              ),
            $comment->comment_ID
            );
            ?>
          </p>
        </div>
      </div>

    </div>
    <?php
    break;
    endswitch;
}

/**
 * Get the custom header image
 * f
 * @param obj     $get_header_image The header image array object.
 *
 * @return string                   The img output
 */
function get_the_custom_header_image( $get_header_image ) {

  _deprecated_function( __FUNCTION__, '4.0.0', 'Header_Image::custom_header()' );

  if ( ! isset( $get_header_image->attachment_id ) ) {
    return sprintf(
      '<img src="%s" width="%s" height="%s" alt="%s">',
      $get_header_image->url,
      $get_header_image->width,
      $get_header_image->height,
      GET_BLOGINFO_NAME
    );
  }

  $id = $get_header_image->attachment_id;

  $attr = array(
    'class'   => "center-block img-responsive attachment-$id attachment-header size-header",
    'alt'   => esc_attr( GET_BLOGINFO_NAME ),
    'itemprop'  => 'image',
        );

  $attr = apply_filters( 'italystrap_custom_header_image_attr', $attr );

  $output = wp_get_attachment_image( $id , false, false, $attr );

  return apply_filters( 'italystrap_custom_header_image', $output );
}

/**
 * Return the defaul image
 * Useful for Opengraph
 *
 * @return string Return url of default image
 * @deprecated 3.1 Funzione deprecata in favore di italystrap_get_the_custom_image_url()
 */
function italystrap_get_default_image() {
  _deprecated_function( __FUNCTION__, '3.1' );

  global $theme_mods;

  if ( empty( $theme_mods['default_image'] ) ) {
    return; }

  if ( is_int( $theme_mods['default_image'] ) ) {
    $default_image = wp_get_attachment_url( $theme_mods['default_image'] ); } elseif ( $theme_mods['default_image'] ) {
    $default_image = $theme_mods['default_image'];
    } else { $default_image = TEMPLATEURL . '/img/italystrap-default-image.png'; }

    return esc_url( $default_image );

}

/**
 * Add a favicons to site
 *
 * @link http://www.robertoiacono.it/aggiungere-favicon-wordpress-come-perche/
 */
function ri_wp_favicon() {
  _deprecated_function( __FUNCTION__, '3.1' );

  $favicon = false;

  if ( $GLOBALS['italystrap_options']['favicon'] ) {
    $favicon = $GLOBALS['italystrap_options']['favicon']; } elseif ( is_child_theme() && ! $favicon ) {

    global $pathchild;
    $favicon = $pathchild . '/img/favicon.ico';

    } else {

      $favicon = TEMPLATEURL . '/img/favicon.ico';

    }

    echo '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon . '" />';
}
// add_action('wp_head', 'ri_wp_favicon');
