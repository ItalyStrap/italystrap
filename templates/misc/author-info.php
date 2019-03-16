<?php
/**
 * Template file for Author Info Box
 *
 * @link [URL]
 * @since 1.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Misc;

use ItalyStrap\HTML;

//d($_GET['author_name']);
//d( $this->get( 'author' ) );
//d( $this->get( 'contact' )->render() );

/**
 * Author object
 * @var WP_User
 */
$author_info = $this->get( 'author' );
//d($author_info);
//d($author_info->get( 'description' ));

$contact = $this->get('contact');

/**
 * Check if $author_info exist
 */
if ( ! $author_info ) {
	return;
}

//d($author_info);
//d($author_info->get( 'avatar' ));
//d($author_info->get( 'ID' ));
//d(get_the_author_meta( 'ID' ));

?>
<section <?php HTML\get_attr( 'author_info', array( 'class' => 'author-info well', 'itemprop' => 'author', 'itemscope' => true, 'itemtype' => 'https://schema.org/Person' ), true ); ?>>
	<div class="row">
		<div class="col-sm-2">
			<?php
			if ( $author_info->avatar ) :
            ?><img src="<?php echo \esc_url( $author_info->avatar ); ?>" alt="avatar autore" class="img-circle img-responsive center-block" width="96" height="96" itemprop="image" />
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
				<p itemprop="description"><?php echo \do_shortcode( \wp_kses_post( $author_info->description ) ); ?></a></p>
			<?php } ?>
			<?php if ( $author_info->user_url ) { ?>
				<p itemprop="url"><strong><?php \esc_attr_e( 'Web site:', 'italystrap' ); ?></strong> <a href="<?php echo \esc_html( $author_info->user_url ); ?>"><?php echo \esc_html( $author_info->user_url ); ?></a></p>
			<?php } ?>

			<?php // echo $this->contact->render(); ?>

			<ul class="list-inline">
				<?php
				if ( $author_info->twitter ) { ?>
					<li><a href="<?php echo \esc_html( $author_info->twitter ); ?>" title="Twitter" rel="me" class="sprite32 twitter32"></a></li>
				<?php }
				if ( $author_info->fb_profile ) { ?>
					<li><a href="<?php echo \esc_html( $author_info->fb_profile ); ?>" title="Facebook" rel="me" class="sprite32 facebook32"></a></li>
				<?php }
				if ( $author_info->skype ) { ?>
					<li><a href="skype:<?php echo \esc_attr( $author_info->skype ); ?>?chat" title="skype" rel="me" class="sprite32 skype32"></a></li>
				<?php }
				if ( $author_info->linkedIn ) { ?>
					<li><a href="<?php echo \esc_html( $author_info->linkedIn ); ?>" title="linkedIn" rel="me" class="sprite32 linkedin32"></a></li>
				<?php }
				if ( $author_info->pinterest ) { ?>
					<li><a href="<?php echo \esc_html( $author_info->pinterest ); ?>" title="pinterest" rel="me" class="sprite32 pinterest32"></a></li>
				<?php }
				?>
			</ul>

		</div><!-- / .col-sm-10 -->
	</div><!-- / .row schema -->
</section>
