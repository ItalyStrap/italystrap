<?php
/**
 * The template part for header.php
 * This file is for display the HTML tags header and nav
 */

namespace ItalyStrap\Headers;

?><header class="header-wrapper">
	<?php \do_action( 'header_open' ); ?>
	<div class="<?php echo \esc_attr( $this->get('custom_header')['container_width'] ); ?>">
		<div class="row">
			<div class="col-md-12">
				<a href="<?php echo \esc_url( HOME_URL ); ?>" rel="home">
					<?php echo $this->get('output'); ?>
				</a>
			</div>
		</div>
	</div>
	<?php \do_action( 'header_closed' ); ?>
</header>
