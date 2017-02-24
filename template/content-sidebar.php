<?php
/**
 * File template for sidebar
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap;

/**
 * @todo Finire di sistemare do_action in quest file
 */
?>
<aside <?php Core\get_attr( 'sidebar', array( 'itemscope' => true, 'itemtype' => 'https://schema.org/WPSideBar' ), true ); ?>>
	<?php do_action( 'italystrap_before_sidebar_widget_area' ); ?>
	<?php do_action( 'italystrap_sidebar' ); ?>
	<?php do_action( 'italystrap_after_sidebar_widget_area' ); ?>
</aside>
