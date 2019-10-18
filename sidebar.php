<?php
/**
 * The sidebar template file.
 */
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag_e, close_tag_e};

/**
 * @todo Finire di sistemare do_action in quest file
 *       Vedere content-sidebar.php
 */

open_tag_e( 'sidebar', 'aside' );

    \do_action( 'italystrap_before_sidebar_widget_area' );
    \do_action( 'italystrap_sidebar' );

    ?>
	<div class="row">
		<?php \dynamic_sidebar( 'Sidebar' ); ?>
	</div>
    <?php

    \do_action( 'italystrap_after_sidebar_widget_area' );

close_tag_e( 'sidebar' );
