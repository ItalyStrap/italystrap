<?php
/**
 * The sidebar template file.
 */

namespace ItalyStrap;

?>
<aside class="col-md-4" itemscope itemtype="http://schema.org/WPSideBar">
<?php do_action( 'sidebar_col_open' ); ?>
	<div class="row">
		<?php dynamic_sidebar( 'Sidebar' ); ?>
	</div>
<?php do_action( 'sidebar_col_closed' ); ?>
</aside>
