<?php
/**
 * The template used for displaying content
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

$template_settings = (array) apply_filters( 'italystrap_template_settings', array() );

if ( in_array( 'hide_content', $template_settings, true ) ) {
	return;
}

?>
<div class="entry-content" itemprop="articleBody"><?php the_content(); ?></div>