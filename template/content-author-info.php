<?php namespace ItalyStrap;
/**
 * Author object
 * @var object
 */
$author_info = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( absint( get_the_author_meta( 'ID' ) ) );

/**
 * Check if $author_info exist
 */
if ( ! $author_info )
	return;
?>
<section class="well" itemprop="author" itemscope itemtype="http://schema.org/Person">
	<div class="row">
		<div class="col-sm-2">
			<?php
			if ( $author_info->avatar ) : ?>
				<img src="<?php echo esc_html( $author_info->avatar ); ?>" alt="avatar autore" class="img-circle img-responsive" width="96" height="96" itemprop="image" />
			<?php else :

				echo italystrap_get_avatar( get_the_author_meta( 'ID' ), 94, null, $author_info->nickname, 'img-circle img-responsive' );

			endif;?>
		</div><!-- / .col-sm-2 -->
		<div class="col-sm-10">
			<h4 class="author-nick"><?php echo esc_attr( $author_info->nickname ); ?></h4>
			<?php if ( $author_info->description ) { ?>
				<p itemprop="description"><?php echo esc_attr( $author_info->description ); ?></a></p>
			<?php } ?>
			<?php if ( $author_info->user_url ) { ?>
				<p itemprop="url"><strong><?php esc_attr_e( 'Web site:', 'ItalyStrap' ); ?></strong> <a href="<?php echo esc_html( $author_info->user_url ); ?>"><?php echo esc_html( $author_info->user_url ); ?></a></p>
			<?php } ?>

			<ul class="list-inline">
				<?php
				if ( $author_info->twitter ) { ?>
					<li><a href="<?php echo esc_html( $author_info->twitter ); ?>" title="Twitter" rel="me" class="sprite32 twitter32"></a></li>
				<?php }
				if ( $author_info->fb_profile ) { ?>
					<li><a href="<?php echo esc_html( $author_info->fb_profile ); ?>" title="Facebook" rel="me" class="sprite32 facebook32"></a></li>
				<?php }
				if ( $author_info->google_profile ) { ?>
					<li><a href="<?php echo esc_html( $author_info->google_profile ); ?>" title="Google+" rel="me" class="sprite32 googleplus32"></a></li>
				<?php }
				if ( $author_info->skype ) { ?>
					<li><a href="skype:<?php echo esc_attr( $author_info->skype ); ?>?chat" title="skype" rel="me" class="sprite32 skype32"></a></li>
				<?php }
				if ( $author_info->google_page ) { ?>
					<li><a href="<?php echo esc_html( $author_info->google_page ); ?>" title="Google Business page" rel="me" class="sprite32 googleplus32"></a></li>
				<?php }
				if ( $author_info->linkedIn ) { ?>
					<li><a href="<?php echo esc_html( $author_info->linkedIn ); ?>" title="linkedIn" rel="me" class="sprite32 linkedin32"></a></li>
				<?php }
				if ( $author_info->pinterest ) { ?>
					<li><a href="<?php echo esc_html( $author_info->pinterest ); ?>" title="pinterest" rel="me" class="sprite32 pinterest32"></a></li>
				<?php }
				?>
			</ul>

		</div><!-- / .col-sm-10 -->
	</div><!-- / .row schema -->
</section>
