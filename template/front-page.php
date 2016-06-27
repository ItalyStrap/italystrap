<?php
/**
 * The front-page template file.
 *
 * This is an example of a custom home page
 * In your home page will view a bootstrap slideshow with Custom Post Type "Prodotti" on the top of content
 * If the CPT Prodotti is empty the BT slide won't be showing
 * In the new CPT editor check meta box top-left if you want to show the new image product
 * The CPT must have a feautured image
 *
 * @example for loading carousel only if is not smarphone
 *          use if (!$detect->isMobile()){}
 *          It works also for any code
 *          In example here below the if is
 *          if ( $prodotti->have_posts() && ! $detect->isMobile() ):
 * @example You can also use css class hidden-xxs for hide element but it still remain in HTML
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

get_header();
do_action( 'italystrap_before_main' );
?>
<!-- Main Content -->
	<main id="<?php echo esc_attr( $context ); ?>">
		<div class="container">
			<div class="row">
				<?php do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( $context, array( 'class' => 'col-md-8', 'itemscope' => true, 'itemtype' => 'http://schema.org/CollectionPage' ), true ); ?>>
					<?php
					do_action( 'italystrap_before_loop' );

					if ( have_posts() ) :

						while ( have_posts() ) :

							the_post();

							get_template_part( 'loops/content', get_post_type() );

						endwhile;

						bootstrap_pagination();

					else :

						get_template_part( 'loops/content', 'none' );

					endif;

					do_action( 'italystrap_after_loop' ); ?>
				</div><!-- / .col-md-x -->
				<?php do_action( 'italystrap_after_content' ); ?>
			</div><!-- / .row -->
	    </div><!-- / .container -->
	</main><!-- / main -->
<?php
do_action( 'italystrap_after_main' );
get_footer();
