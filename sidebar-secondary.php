<?php
/**
 * The sidebar template file.
 * This file is still in beta version, dont use this sidebar
 */

namespace ItalyStrap;

/**
 * @todo Finire di sistemare do_action in quest file
 *       Vedere content-sidebar.php
 */
?>
<aside <?php Core\get_attr( 'sidebar-secondary', array( 'itemscope' => true, 'itemtype' => 'http://schema.org/WPSideBar' ), true ); ?>>
<?php do_action( 'italystrap_before_sidebar_secondary_widget_area' ); ?>
	<?php do_action( 'italystrap_sidebar_secondary' ); ?>
	<div class="row">
		<?php dynamic_sidebar( 'Sidebar-secondary' ); ?>
	</div>
<?php do_action( 'italystrap_after_sidebar_secondary_widget_area' ); ?>
</aside>
