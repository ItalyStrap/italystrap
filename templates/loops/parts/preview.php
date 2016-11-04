<?php
/**
 * The template used for displaying page content
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

if ( ! is_preview() ) {
	return;
}

?>
<div class="alert alert-info">  
	<?php esc_attr_e( '<strong>Note:</strong> You are previewing this post. This post has not yet been published.', 'ItalyStrap' ); ?>  
</div>