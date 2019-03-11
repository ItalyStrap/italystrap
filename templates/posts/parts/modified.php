<?php
/**
 * The template used for displaying last edit message
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

?><p class="sr-only"><?php esc_attr_e( 'Last edit:', 'italystrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p><span class="clearfix">&nbsp;</span>
