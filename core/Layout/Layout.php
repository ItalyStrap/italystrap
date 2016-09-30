<?php
/**
 * Layout API: Layout Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Layout;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

/**
 * Layout Class
 */
class Layout {

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
		$this->theme_mod['site-layout'] = '$theme_mod';
	}

	/**
	 * [get_layout_settings description]
	 *
	 * @return array Return the array with template part settings.
	 */
	public function get_template_settings() {

		/**
		 * Front page ID get_option( 'page_on_front' );
		 * Home page ID get_option( 'page_for_posts' );
		 */

		$id = '';

		if ( is_home() ) {
			$id = get_option( 'page_for_posts' );
		} else {
			$id = get_the_ID();
		}

		return get_post_meta( $id, '_italystrap_template_settings', true );
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function get_site_layout( $attr, $context, $args ) {

		// $italystrap_theme_mods['site-layout']

		// add_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );
		// add_action( 'italystrap_before_content', array( $this, 'get_sidebar' ) );
		// add_action( 'italystrap_before_content', array( $this, 'get_sidebar' ) );

		if ( 'front-page' === CURRENT_TEMPLATE_SLUG && is_home() === false ) {
			$attr['class'] = 'col-md-12';
			$attr['itemtype'] = 'http://schema.org/Article';
			remove_action( 'italystrap_after_content', array( $this, 'get_sidebar' ) );
			return $attr;
		}

		if ( 'home' === CURRENT_TEMPLATE_SLUG ) {
			$attr['class'] = 'col-md-8';
			return $attr;
		}

		if ( 'index' === CURRENT_TEMPLATE_SLUG ) {
			// $attr['class'] = 'col-md-8';
			return $attr;
		}

		if ( 'page' === CURRENT_TEMPLATE_SLUG ) {
			// $attr['class'] = 'col-md-8';
			$attr['itemtype'] = 'http://schema.org/Article';
			return $attr;
		}

		if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
			// $attr['class'] = 'col-md-8';
			$attr['itemtype'] = 'http://schema.org/Article';
			return $attr;
		}

		if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
			// $attr['class'] = 'col-md-8';
			$attr['itemtype'] = 'http://schema.org/SearchResultsPage';
			return $attr;
		}

		return $attr;
	
	}

	// add_action( 'genesis_after_content', 'genesis_get_sidebar' );
	/**
	 * Output the sidebar.php file if layout allows for it.
	 *
	 * @since 4.0.0
	 */
	function get_sidebar() {

		$site_layout = 'content-sidebar';

		//* Don't load sidebar on pages that don't need it
		if ( 'full-width' === $site_layout )
			return;

		get_sidebar();

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

	/**
	 * Page Layout
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function page_layout( $value = '' ) {
	
		
		return;
	}
}
