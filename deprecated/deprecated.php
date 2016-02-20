<?php
/**
 * Classes and functions deprecated
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

use \ItalyStrap\Core;
use \ItalyStrap\Core\Bootstrap_Nav_Menu;

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
