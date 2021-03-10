<?php
/**
 * Template file for Author Info Box
 *
 * @link [URL]
 * @since 1.0.0
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap\Misc;

use ItalyStrap\HTML;

/**
 * Author object
 * @var \WP_User
 */
$author_info = $this->get( 'author' );

/**
 * Check if $author_info exist
 */
if ( ! $author_info ) {
	return;
}

?>
<section <?php HTML\get_attr_e(
	'author_info',
	[
			'class' => 'author-info well',
			'itemprop' => 'author',
			'itemscope' => true,
			'itemtype' => 'https://schema.org/Person'
		]
); ?>>
	<div class="row">
		<div class="col-sm-2">
			<?php
			if ( $author_info->avatar ) :
				?>
				<img
						src="<?php echo \esc_url( $author_info->avatar ); ?>"
						alt="avatar autore"
						class="img-circle img-responsive center-block"
						width="96"
						height="96"
						itemprop="image"
				/>
				<?php
			endif;?>
			<?php echo \get_avatar(
				$author_info->get('ID'),
				94, // Size
				null, // Default image URL
				$author_info->get('nickname'),
				[ 'class' => 'img-circle img-responsive center-block' ]
			); ?>

		</div><!-- / .col-sm-2 -->
		<div class="col-sm-10">
			<h4 class="author-nick" itemprop="name"><?php echo \esc_attr( $author_info->nickname ); ?></h4>
			<?php if ( $author_info->description ) { ?>
				<p itemprop="description">
					<?php echo \do_shortcode( \wp_kses_post( $author_info->description ) ); ?>
				</p>
			<?php } ?>
			<?php if ( $author_info->user_url ) { ?>
				<p itemprop="url">
					<strong>
						<?php \esc_attr_e( 'Web site:', 'italystrap' ); ?>
					</strong> <a href="<?php echo \esc_html( $author_info->user_url ); ?>">
						<?php echo \esc_html( $author_info->user_url ); ?>
					</a>
				</p>
			<?php } ?>
		</div><!-- / .col-sm-10 -->
	</div><!-- / .row schema -->
</section>
