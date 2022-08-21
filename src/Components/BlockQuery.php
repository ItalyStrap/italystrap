<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\Components;

class BlockQuery implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface {

	use SubscribedEventsAware;

	public const EVENT_NAME = 'italystrap_after_loop';
	public const EVENT_PRIORITY = 10;

//    private ConfigInterface $config;
//    private ViewInterface $view;
//
//    public function __construct( ConfigInterface $config, ViewInterface $view  ) {
//        $this->config = $config;
//        $this->view = $view;
//    }

	public function shouldDisplay(): bool {
		return ! \is_404();
	}

	public function display(): void {
		\ob_start();

		?>

		<!-- wp:group {"tagName":"main","layout":{"inherit":true}} -->
		<main class="wp-block-group">

			<!-- wp:query {"queryId":1,"query":{"perPage":"10","pages":"100","offset":0,"postType":"post","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","sticky":"","inherit":true}} -->

			<!-- wp:post-template -->

			<!-- wp:group {"tagName":"article","layout":{"inherit":true}} -->
			<article class="wp-block-group">

				<!-- wp:post-featured-image {"align":"wide"}  /-->

				<!-- wp:group {"layout":{"inherit":true}} -->
				<div class="wp-block-group">
					<!-- wp:post-title {"isLink":true} /-->
					<!-- wp:post-excerpt {"moreText":"Read more..."} /-->
				</div>
				<!-- /wp:group -->


				<!-- wp:group {"layout":{"inherit":true}} -->
				<div class="wp-block-group">

					<!-- wp:separator {"align":"center"} -->
					<hr class="wp-block-separator aligncenter"/>
					<!-- /wp:separator -->

					<!-- wp:template-part {"slug":"meta","layout":{"inherit":true}} /-->

					<!-- wp:post-author {"showAvatar":false} /-->

				</div>
				<!-- /wp:group -->

			</article>
			<!-- /wp:group -->

			<!-- /wp:post-template -->

			<!-- wp:query-pagination {"paginationArrow":"chevron","layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-query-pagination">
				<!-- wp:query-pagination-previous /-->

				<!-- wp:query-pagination-numbers /-->

				<!-- wp:query-pagination-next /-->
			</div>
			<!-- /wp:query-pagination -->

			<!-- /wp:query -->

		</main>
		<!-- /wp:group -->

		<?php
		echo \do_blocks( \ob_get_clean() );
	}
}
