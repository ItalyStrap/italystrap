<?php

		echo '<article>';

			do_action( 'italystrap_entry_header' );

				do_action( 'italystrap_before_entry_content' );

					do_action( 'italystrap_entry_content' );

				do_action( 'italystrap_after_entry_content' );

			do_action( 'italystrap_entry_footer' );

		echo '</article>';

