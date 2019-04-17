<?php
/**
 * The template used for displaying content
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

use function ItalyStrap\HTML\{open_tag_e, close_tag_e};

open_tag_e( 'entry_content', 'div' );

    if ( \is_singular() ) {
        \the_content();
    } else {
        \the_excerpt();
    }

close_tag_e( 'entry_content' );
