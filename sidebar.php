<?php
/**
 * The sidebar template file.
 */

namespace ItalyStrap;

/**
 * @todo Finire di sistemare do_action in quest file
 *       Vedere content-sidebar.php
 */
?>
<aside <?php Core\get_attr( 'sidebar', [], true ); ?>>
<?php do_action( 'italystrap_before_sidebar_widget_area' ); ?>
	<?php do_action( 'italystrap_sidebar' ); ?>
	<div class="row">
		<?php dynamic_sidebar( 'Sidebar' ); ?>
	</div>
<?php do_action( 'italystrap_after_sidebar_widget_area' ); ?>
</aside>
