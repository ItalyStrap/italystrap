<?php
/**
 * The main template file.
 *
 * By default, WordPress sets your site’s home page to display your latest blog posts.
 * This page is called the blog posts index.
 * You can also set your blog posts to display on a separate static page.
 * The template file home.php is used to render the blog posts index,
 * whether it is being used as the front page or on separate static page.
 * If home.php does not exist, WordPress will use index.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

\get_header();
\do_action( 'italystrap_before_main' );
/**
 * @todo Per il momento questa variabile non è utilizzata
 */
$file_name = isset( $file_name ) ?: '';
?>
<!-- Main Content -->
	<main id="<?php echo \esc_attr( $file_name ); ?>">
		<div class="container">
			<div class="row">
				<?php \do_action( 'italystrap_before_content' ); ?>
				<div <?php Core\get_attr( 'content', [], true ); ?>>

					<?php \do_action( 'italystrap_before_loop' ); ?>

					<?php \do_action( 'italystrap_loop' ); ?>

					<?php \do_action( 'italystrap_after_loop' ); ?>

				</div><!-- / .col-md-8 -->
				<?php \do_action( 'italystrap_after_content' ); ?>
			</div><!-- / .row -->
		</div>
	</main><!-- / main -->
<?php
\do_action( 'italystrap_after_main' );
\get_footer();
