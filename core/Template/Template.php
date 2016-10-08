<?php
/**
 * Template API: Template Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Template;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Template Class
 */
class Template {

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	private $theme_mod = array();

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mod = array() ) {
		$this->theme_mod = $theme_mod;
	}

	/**
	 * Get the ID
	 *
	 * @return int        The current content ID
	 */
	public function get_the_ID() {
	
		if ( is_home() ) {
			return PAGE_FOR_POSTS;
		}

		return get_the_ID();
	
	}

	/**
	 * [get_template_settings description]
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_template_settings() {

		/**
		 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
		 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
		 */

		return get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function pagination() {

		// if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
		// 	return null;
		// }
	
		bootstrap_pagination();
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function content_none() {
	
		get_template_part( 'loops/content', 'none' );
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function comments_template() {

		if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		comments_template();
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function author_info() {

		if ( 'author' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		get_template_part( 'template/content', 'author-info' );
	
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function archive_headline() {

		if ( 'archive' !== CURRENT_TEMPLATE_SLUG && 'author' !== CURRENT_TEMPLATE_SLUG && 'search' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		?>
		<header class="page-header">
			<?php 

			if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
				?>
				<h1 itemprop="headline"><?php printf( esc_html__( 'Search result of: %s', 'ItalyStrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
				return null;
			}

			?>
			<?php
			the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
			the_archive_description( '<div class="well taxonomy-description" role="alert" itemprop="description">', '</div>' );

			/**
			 * Display or retrieve title for a Custom Post Type archive.
			 * This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the CPT.
			 */
			if ( is_post_type_archive() ) {

				$cpt_description = get_post_type_object( get_post_type() );

				if ( $cpt_description ) { ?>

				<div class="well" role="alert" itemprop="description"><p>
					<?php echo esc_attr( $cpt_description->description ); ?>
				</p></div>

				<?php }
			} ?>
		</header>
		<?php
	
	}
}
