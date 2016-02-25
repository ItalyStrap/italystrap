<?php namespace ItalyStrap;
/**
 * The template part for header.php
 * This file is for display the HTML tags header and nav
 */

/**
 * Get the header object
 *
 * @var object
 */
$get_header_image = get_custom_header();

/**
 * If header image is set then load header
 */
if ( $get_header_image->url ) :?>
	<header class="header-wrapper">
		<?php do_action( 'header_open' ); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo esc_url( HOME_URL ); ?>" rel="home">
						<?php echo Core\get_the_custom_header_image( $get_header_image->attachment_id ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php do_action( 'header_closed' ); ?>
	</header>
<?php endif; ?>
