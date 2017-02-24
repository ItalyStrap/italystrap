<body>

	<?php do_action( 'body_open' ); ?>

	<div class="wrapper">

		<?php do_action( 'wrapper_open' ); ?>

		<header class="header-wrapper">

			<?php do_action( 'header_open' ); ?>

			<div class="container">

			</div>

			<?php do_action( 'header_closed' ); ?>

		</header>

		<nav class="container navbar-wrapper" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">

			<?php do_action( 'nav_open' ); ?>

				<div class="navbar navbar-inverse navbar-relative-top">
					<div class="container-fluid">

						<?php do_action( 'before_wp_nav_menu' );?>

						<?php do_action( 'after_wp_nav_menu' );?>

					</div>
				</div>

			<?php do_action( 'nav_closed' ); ?>

		</nav>

		<section id="page">
			<div class="container">
				<?php do_action( 'content_container_open' ); ?>
				<div class="row">
					<div class="col-md-8">
						<?php
						do_action( 'content_col_open' );

						if ( have_posts() ) : while ( have_posts() ) : the_post();

						get_template_part( 'loops/content', 'page' );



						endwhile;
						else:

							get_template_part( 'loops/content', 'none');

						endif;

						comments_template(); ?> 	
						<?php do_action( 'content_col_closed' ); ?>
					</div><!-- / .col-md-8 -->

					<aside class="col-md-4" itemscope itemtype="https://schema.org/WPSideBar">

						<?php do_action( 'sidebar_col_open' ); ?>

						<div class="row">

						</div>

						<?php do_action( 'sidebar_col_closed' ); ?>

					</aside>

				</div><!-- / .row -->
				<?php do_action( 'content_container_closed' ); ?>
			</div><!-- / .container -->
		</section><!-- / #page -->

		<footer itemscope itemtype="https://schema.org/WPFooter">

			<?php do_action( 'footer_open' ); ?>

			<div class="container">

			</div>

			<?php do_action( 'footer_closed' ); ?>

		</footer><!-- #footer -->

		<?php do_action( 'wrapper_closed' ); ?>

	</div><!-- Wrapper -->

	<?php do_action( 'body_closed' );?>

</body>