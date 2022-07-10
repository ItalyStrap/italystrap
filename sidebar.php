<?php
/**
 * The sidebar template file.
 */
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\close_tag_e;

/**
 * @todo Finire di sistemare do_action in quest file
 *       Vedere content-sidebar.php
 * @todo Usare il sidebar_id della dynamic_sidebar() come context?
 */

open_tag_e( 'sidebar', 'aside' );

	\do_action( 'italystrap_before_sidebar_widget_area' );
	\do_action( 'italystrap_sidebar' );

		open_tag_e( 'sidebar-row', 'div', [ 'class' => 'row' ] );
			\dynamic_sidebar( 'Sidebar-1' );
		close_tag_e( 'sidebar-row' );

	\do_action( 'italystrap_after_sidebar_widget_area' );

close_tag_e( 'sidebar' );
