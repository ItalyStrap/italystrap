<?php
/**
 * The template used for displaying content
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

?><div <?php Core\get_attr( 'entry_content', array( 'class' => 'entry-content', 'itemprop' => 'articleBody' ), true ); ?>><?php if ( is_singular() ) { the_content(); } else { the_excerpt(); } ?></div>
