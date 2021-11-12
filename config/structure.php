<?php
declare(strict_types=1);
namespace ItalyStrap;

use ItalyStrap\Builders\Builder;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface as Subscriber;
use function ItalyStrap\Factory\get_config;
use function ItalyStrap\Core\get_template_settings;

/**
 * ====================================================================
 *
 * This file has to be loaded after 'wp' hook
 *
 * @todo Verificare eventuali problemi di priorità con gli hook
 *
 * ====================================================================
 */
return [

		'breadcrumbs'	=> [
			Builder::EVENT_NAME	=> 'italystrap_before_loop',
			Subscriber::PRIORITY	=> 10, // Optional
			'should_load'	=> static function ( ConfigInterface $config ): bool {
				return \current_theme_supports( 'breadcrumbs' )
					&& \in_array(
						CURRENT_TEMPLATE,
						\explode( ',', $config->get( 'breadcrumbs_show_on', '' ) ),
						true
					)
					&& ! \in_array( 'hide_breadcrumbs', get_template_settings(), true );
			},
			'callback'	=> static function ( EventDispatcherInterface $dispatcher ): string {
				$args = [
//					'home'	=> '<i class="glyphicon glyphicon-home" aria-hidden="true"></i>',
				];

				\ob_start();
				$dispatcher->dispatch( 'do_breadcrumbs', $args );
				return \strval( \ob_get_clean() );
			},
		],

		'featured-image'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 10, // Optional
			'should_load'	=> static function () : bool {
				return \post_type_supports( \strval( \get_post_type() ), 'thumbnail' )
					&& ! \in_array( 'hide_thumb', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/featured-image',
			'data'	=> static function ( ConfigInterface $config ) : ConfigInterface {
				if ( \is_singular() ) {
					$config->add( 'post_thumbnail_size', 'post-thumbnail' );
					$config->add( 'post_thumbnail_alignment', 'aligncenter' );
				}

				return $config;
			},
		],

		'title'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 20, // Optional
			'should_load'	=> static function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'title' )
					&& ! \in_array( 'hide_title', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/title',
//			'data'	=> static function ( ConfigInterface $config ) : ConfigInterface {
//					$config->push( 'title', \get_the_title() );
//				return $config;
//			},
		],

		'meta'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 30, // Optional
			'should_load'	=> static function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'entry-meta' )
					&& ! \in_array( 'hide_meta', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/meta',
		],

		'preview'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 40, // Optional
			'view'	=> 'posts/parts/preview',
		],

		'content'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 50, // Optional
			'should_load'	=> static function () : bool {

				/**
				 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
				 * || ! post_type_supports( $post_type, 'excerpt' )
				 * @todo Vadere di fare un controllo sulle pagine perchè ovviamente non hanno il riassunto
				 *       e con il controllo sopra sparisce il contenuto e non va bene.
				 */
				return \post_type_supports(  \strval( \get_post_type() ), 'editor' )
					&& ! \in_array( 'hide_content', get_template_settings(), true );
			},
			'view'	=> 'posts/parts/content',
		],

		'modified'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 60, // Optional
			'view'	=> 'posts/parts/modified',
		],

//		'edit-post-link'	=> [
//			Builder::self::EVENT_NAME	=> 'italystrap_after_entry_content',
//			Subscriber::PRIORITY	=> 999, // Optional
//			'callback'	=> [ Controllers\Posts\Parts\Edit_Post_Link::class, 'render' ], // Optional
//		],

		'link-pages'	=> [
			Builder::EVENT_NAME	=> 'italystrap_entry_content',
			Subscriber::PRIORITY	=> 70, // Optional
			'should_load'	=> static function () : bool {
				return \is_single();
			},
			'callback'	=> [ Components\Navigations\LinkPages::class, 'render' ], // Optional
		],

		'pager'	=> [
			Builder::EVENT_NAME	=> 'italystrap_after_entry_content',
			'should_load'	=> static function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'post_navigation' )
					&& \is_single();
			},
			'callback'	=> static function (): string {
				// Back compat style
				$style = '<style>
.wp-block-post-navigation-link-container {
	display: flex;
	flex-direction: row;
	justify-content: space-between;
}
.post-navigation-link-next a {
	display: flex;
	flex-direction: row-reverse;
}
.post-navigation-link-next .post-navigation-link__label {
        margin-left: 1ch;
    }
</style>';
				$pager_blocks = '<div class="wp-block-post-navigation-link-container"><!-- wp:post-navigation-link {"type":"previous","label":"«","showTitle":true,"linkLabel":true,"fontSize":"x-small"} /-->
				<!-- wp:post-navigation-link {"label":"»","showTitle":true,"linkLabel":true,"fontSize":"x-small"} /--></div>';

				return $style . \do_blocks( $pager_blocks );
			},
		],

		'pagination'	=> [
			Builder::EVENT_NAME	=> 'italystrap_after_loop',
			'should_load'	=> static function () : bool {
				return ! \is_404();
			},
			'callback'	=> [ Components\Navigations\Pagination::class, 'render' ], // Optional
		],

		'new_loop'	=> [
			Builder::EVENT_NAME	=> 'italystrap_after_loop_test',
			'should_load'	=> static function () : bool {
				return ! \is_404();
			},
			'callback'	=> static function () {

				ob_start();

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
				return \do_blocks( \ob_get_clean() );

			}, // Optional
		],

		'sidebar'	=> [
			Builder::EVENT_NAME	=> 'italystrap_after_content',
			'callback'	=> '\get_sidebar',
			'should_load'	=> static function ( ConfigInterface $config ) : bool {
				return 'full_width' !== $config->get( 'site_layout' );
			},
			/**
			 * @TODO Maybe for WooCommerce, for now is only for remember
			 */
//			'callback_to_develope'	=> static function () {
//
//				/**
//				 * Don't load sidebar on pages that doesn't need it
//				 */
//				if ( 'full_width' === $config->get( 'site_layout' ) ) {
//					/**
//					 * This hook is usefull for example when you need to remove the
//					 * WooCommerce sidebar on full width page.
//					 *
//					 * @example
//					 * add_action( 'italystrap_full_width_layout', static function () {
//					 *     remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
//					 * }, 10 );
//					 */
//					do_action( 'italystrap_full_width_layout' );
//					return;
//				}
//
//				\get_sidebar();
//
//		//		if ( in_array( $this->layout->get_layout_settings(), array(), true ) ) {
//		//			get_sidebar( 'secondary' );
//		//		}
//			}, // Optional
		],

		'entry'	=> [
		Builder::EVENT_NAME	=> 'italystrap_entry',
		'view'	=> 'posts/post',
		'data'	=> static function () : array {
			return (array) \get_post( null, ARRAY_A );
		},
		],

		/**
		 * ====================================================================
		 *
		 * The content none components
		 *
		 * ====================================================================
		 */
		'none-image'	=> [
			Builder::EVENT_NAME			=> 'italystrap_entry_content_none',
			'view'			=> 'posts/none/image',
		],

		'none-title'	=> [
			Builder::EVENT_NAME			=> 'italystrap_entry_content_none',
			Subscriber::PRIORITY		=> 20,
			'view'			=> 'posts/none/title',
			'data'			=> static function ( ConfigInterface $config ) : ConfigInterface {
				return $config;
			},
		],

		'none-content'	=> [
			Builder::EVENT_NAME			=> 'italystrap_entry_content_none',
			Subscriber::PRIORITY		=> 30,
			'view'			=> 'posts/none/content',
			'data'			=> static function ( ConfigInterface $config ) : ConfigInterface {
				return $config;
			},
		],

		'none'	=> [
		Builder::EVENT_NAME	=> 'italystrap_content_none',
		'view'	=> 'posts/none',
		],

		'archive-headline'	=> [
			Builder::EVENT_NAME		=> 'italystrap_before_while',
			Subscriber::PRIORITY	=> 20,
			'view'		=> 'misc/archive-headline',
			'should_load'	=> static function () : bool {
				return ( \is_archive() || \is_search() ) && ! \is_author();
			},
		],

		/**
		 * @TODO Refactor dupplicate code in 'data'
		 */
		'author-info'	=> [
			Builder::EVENT_NAME		=> 'italystrap_before_loop',
			Subscriber::PRIORITY	=> 20,
			'view'		=> 'misc/author-info',
			'should_load'	=> 'is_author',
			'data'		=> static function ( Injector $injector ) : array {

				$data = [];
				global $author_name;
				$data['author'] = \array_key_exists( 'author_name', $_GET )
					? \get_user_by( 'slug', $author_name )
					: \get_userdata( \absint( \get_the_author_meta( 'ID' ) ) );

				return $data;
			},
		],
		// @todo Rename the key with a better name
		'author-info-1'	=> [
			Builder::EVENT_NAME		=> 'italystrap_after_entry_content',
			Subscriber::PRIORITY	=> 30,
			'view'		=> 'misc/author-info',
			'should_load'	=> static function () : bool {
				return \post_type_supports(  \strval( \get_post_type() ), 'author' )
					&& \is_singular()
					&& ! \in_array( 'hide_author', get_template_settings(), true );
			},
			'data'		=> static function ( Injector $injector ) : array {

				$data = [];
				global $author_name;
				$data['author'] = \array_key_exists( 'author_name', $_GET )
					? \get_user_by( 'slug', $author_name )
					: \get_userdata( \absint( \get_the_author_meta( 'ID' ) ) );

				return $data;
			},
		],

	/**
	 * ====================================================================
	 *
	 * The loop
	 *
	 * ====================================================================
	 */
		'loop'	=> [
		Builder::EVENT_NAME	=> 'italystrap_loop',
		'view'	=> ['posts/loop'],
		],

		'navbar-top'	=> [
			Builder::EVENT_NAME		=> 'italystrap_before_header',
			'view'		=> 'headers/navbar-top',
			'should_load'	=> static function () : bool {
				return \has_nav_menu( 'info-menu' )
					&& \has_nav_menu( 'social-menu' );
			},
		],

		'custom-header'	=> [
			Builder::EVENT_NAME		=> 'italystrap_content_header',
			'view'		=> 'headers/custom-header',
			'should_load'	=> '\has_header_image',
			'data'		=> static function ( Injector $injector ) {
				return $injector->make( Components\Headers\CustomHeader::class )->getData();
			},
		],

		'navbar'	=> [
			Builder::EVENT_NAME		=> 'italystrap_after_header',
			'view'		=> 'headers/navbar',
			'data'	=> static function ( Injector $injector, ConfigInterface $config ) : array {
				return [
					'mods'		=> $config,
					'navbar'	=> $injector->make( Components\Navigations\Navbar::class ),
				];
			},
		],

		/**
		 * @example it could be added new key 'callback_args' for additional or custom callback arguments
		 * 			They will be provisioned to the callback itself.
		 *
		 * "callback_args => [ 'file' => 'new_comment_template.php' ]"
		 */
		'comments'	=> [
			Builder::EVENT_NAME		=> 'italystrap_after_loop',
			/** @see \comments_template() */
			'callback'	=> static function () {
				echo \do_blocks( '<!-- wp:post-comments /-->' );
			},
			'should_load'	=> static function () : bool {
				return \is_singular()
					&& \post_type_supports( \strval( \get_post_type() ), 'comments' )
					&& ! \in_array( 'hide_comments', get_template_settings(), true );
			},
		],

		'footer-widget-area'	=> [
			Builder::EVENT_NAME		=> 'italystrap_footer',
			'view'		=> 'footers/widget-area',
			'callback'	=> [ Components\Footers\WidgetArea::class, 'render' ],
		],

		'footer-colophon'	=> [
			Builder::EVENT_NAME		=> get_config()->get( 'colophon_action' ),
			Subscriber::PRIORITY	=> get_config()->get( 'colophon_priority' ),
			'view'		=> 'footers/colophon',
		],

	/**
	 * ====================================================================
	 *
	 * The base document page
	 *
	 * ====================================================================
	 */
		'index'	=> [
		Builder::EVENT_NAME	=> 'italystrap',
		'view'	=> 'index',
		],
];
