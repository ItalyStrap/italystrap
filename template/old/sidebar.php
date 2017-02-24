<?php
/**
 * The sidebar template file.
 */

namespace ItalyStrap;

?>
<aside <?php Core\get_attr( 'sidebar', array( 'class' => 'col-md-4', 'itemscope' => true, 'itemtype' => 'https://schema.org/WPSideBar' ), true ); ?>>
<?php do_action( 'sidebar_col_open' ); ?>
	<div class="row">
		<?php dynamic_sidebar( 'Sidebar' ); ?>
	</div>
<?php do_action( 'sidebar_col_closed' ); ?>
</aside>
