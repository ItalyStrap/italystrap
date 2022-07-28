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
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Event\EventDispatcherInterface;
use function ItalyStrap\HTML\open_tag_e;
use function ItalyStrap\HTML\close_tag_e;

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);

/** @var string $container_class_names */
$container_class_names = (string)$this->get('container_class_names');

/** @var string $row_class_names */
$row_class_names = (string)$this->get('row_class_names');

$dispatcher->dispatch( 'italystrap_before_main' );

?>
<!-- wp:group {"tagName":"main","align":"full","layout":{"inherit":false}} -->
<main class="wp-block-group alignfull">
<?php
//	open_tag_e( 'index-container', 'div', [
//			'class' => $container_class_names,
//	] );
//		open_tag_e( 'index-row', 'div', [
//			'class' => $row_class_names,
//		] );

			$dispatcher->dispatch( 'italystrap_before_content' );
		?>
	<!-- wp:columns {"align":"wide","layout":{"inherit":true}} -->
	<div class="wp-block-columns alignwide">

		<!-- wp:column -->
		<div class="wp-block-column">

			<?php
			$dispatcher->dispatch( 'italystrap_before_loop' );

			$dispatcher->dispatch( 'italystrap_loop' );

			$dispatcher->dispatch( 'italystrap_after_loop' );
			?>

		</div>
		<!-- /wp:column -->

			<?php $dispatcher->dispatch( 'italystrap_after_content' ); ?>

	</div>
	<!-- /wp:columns -->
	<?php

//		close_tag_e( 'index-row' );
//	close_tag_e( 'index-container' );
	?>
</main>
<!-- /wp:group -->
<?php
$dispatcher->dispatch( 'italystrap_after_main' );
