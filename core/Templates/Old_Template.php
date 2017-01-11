<?php
/**
 * Template API: Template Class
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

namespace ItalyStrap\Core\Templates;

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
	protected $theme_mod = array();

	protected $registered_path = array(
		'templates',
		'loops',
		'type',
		'parts',
	);

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
	 * Load a template part into a template
	 *
	 * Makes it easy for a theme to reuse sections of code in a easy to overload way
	 * for child themes.
	 *
	 * Includes the named template part for a theme or if a name is specified then a
	 * specialised part will be included. If the theme contains no {slug}.php file
	 * then no template will be included.
	 *
	 * The template is included using require, not require_once, so you may include the
	 * same template part multiple times.
	 *
	 * For the $name parameter, if the file is called "{slug}-special.php" then specify
	 * "special".
	 *
	 * @since 4.0.0
	 *
	 * @see get_template_part() - wp-includes/general-template.php
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 */
	function get_template_part( $slug, $name = null, $load = false ) {
		/**
		 * Fires before the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, `$slug`, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 3.0.0
		 *
		 * @param string      $slug The slug name for the generic template.
		 * @param string|null $name The name of the specialized template.
		 */
		do_action( "italystrap_get_template_part_{$slug}", $slug, $name );

		$templates = array();
		$name = (string) $name;
		if ( '' !== $name )
			$templates[] = "{$slug}-{$name}.php";

		$templates[] = "{$slug}.php";

		if ( $load ) {
			d( $load );
			locate_template($templates, $load, false);
			return;
		}

		require( locate_template($templates, $load, false) );
	}

	/**
	 * filter_template_include
	 *
	 * @param  array $map Array with .
	 * @return array      Return the template path
	 */
	public function filter_template_include( $map ) {
	// 	$new_map = array(
	// 		// 'single.php'	=> 'full-width.php',
	// 		'single.php'	=> array( $this, 'do_loop' ),
	// 	);
	// var_dump( $map, CURRENT_TEMPLATE );
		$map = array(
			'bbpress.php'	=> [ $this, 'test' ],
			// 'bbpress.php'	=> 'bbpress.php',
		);
	// var_dump( $map );
	// 	return $new_map;
		return $map;
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function test( $template ) {
		remove_action( 'italystrap_before_entry_content', array( $this, 'meta' ), 20 );

		return $template;
	}


	/**
	 * Do Loop
	 */
	public function do_loop() {

		$this->get_template_part( 'templates/loops/loop' );
	}

	/**
	 * Do Entry
	 */
	public function do_entry() {
	
		// $file_type = get_post_type();
		// d( $file_type, CURRENT_TEMPLATE_SLUG );
		// if ( 'single' === CURRENT_TEMPLATE_SLUG ) {
		// 	$file_type = 'single';
		// }

		// if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
		// 	$file_type = 'post';
		// }

		$file_type = 'post';

		$this->get_template_part( 'templates/loops/type/'. $file_type );
	
	}

	/**
	 * Title
	 *
	 * @hoocked 'italystrap_before_entry_content' - 10
	 */
	public function title() {
	
		$this->get_template_part( 'templates/loops/type/parts/title' );
	}

	/**
	 * Meta
	 *
	 * @hoocked 'italystrap_before_entry_content' - 20
	 */
	public function meta() {
	
		$this->get_template_part( 'templates/loops/type/parts/meta' );
	}

	/**
	 * Preview
	 *
	 * @hoocked 'italystrap_before_entry_content' - 30
	 */
	public function preview() {
	
		$this->get_template_part( 'templates/loops/type/parts/preview' );
	}

	/**
	 * Featured
	 *
	 * @hoocked 'italystrap_before_entry_content' - 40
	 */
	public function featured() {
	
		$this->get_template_part( 'templates/loops/type/parts/featured', 'image' );
	}

	/**
	 * Content
	 *
	 * @hoocked 'italystrap_entry_content' - 10
	 */
	public function content() {
	
		$this->get_template_part( 'templates/loops/type/parts/content' );
	}

	/**
	 * link_pages
	 *
	 * @hoocked 'italystrap_entry_content' - 20
	 */
	public function link_pages() {

		if ( 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return;
		}

		/**
		 * Arguments for wp_link_pages
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
		 * @var array
		 */
		$args = array(
			'before'	=> '<p class="text-muted lead"><b>' . __( 'Pages:', 'ItalyStrap' ) . '</b>',
			'after'		=> '</p>',
		);
		$args = apply_filters( 'italystrap_wp_link_pages_args', $args );

		wp_link_pages( $args );
	}

	/**
	 * modified
	 *
	 * @hoocked 'italystrap_after_entry_content' - 10
	 */
	public function modified() {
	
		$this->get_template_part( 'templates/loops/type/parts/modified' );
	}

	/**
	 * Edit_post_link
	 *
	 * @hoocked 'italystrap_after_entry_content' - 20
	 */
	public function edit_post_link() {

		/**
		 * Arguments for edit_post_link()
		 *
		 * @var array
		 */
		$args = array(
			/* translators: %s: Name of current post */
			'link_text'	=> __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'italystrap' ),
			'before'	=> '<p>',
			'after'		=> '</p>',
			'class'		=> 'btn btn-sm btn-primary', // 4.4.0
		);

		$args = apply_filters( 'italystrap_edit_post_link_args', $args );

		edit_post_link(
			sprintf(
				$args['link_text'],
				get_the_title()
			),
			$args['before'],
			$args['after'],
			null,
			$args['class']
		);
	}

	/**
	 * Pager for single.php
	 *
	 * @hocked 'italystrap_after_entry' - 10
	 */
	public function pager() {

		if ( 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return;
		}
	
		/**
		 * Arguments for previous_post_link() and next_post_link()
		 *
		 * @var array
		 */
		$args = array(
			'previous_format'	=> '<li class="previous pager-prev"> %link',
			'previous_link'		=> '<i class="glyphicon glyphicon-arrow-left"></i> %title</li>',
			'next_format'		=> '<li class="next pager-next"> %link',
			'next_link'			=> '%title <i class="glyphicon glyphicon-arrow-right"></i></li>',
			);
		$args = apply_filters( 'italystrap_previous_next_post_link_args', $args );
		?>
		<ul class="pager">
			<?php previous_post_link( $args['previous_format'], $args['previous_link'] );
			next_post_link( $args['next_format'], $args['next_link'] ); ?>
		</ul>
		<span class="clearfix"></span><?php
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function content_none() {
	
		$this->get_template_part( 'templates/loops/type/none' );
	}

	/**
	 * Function description
	 */
	public function comments_template() {

		if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		comments_template();
	}

	/**
	 * author_info
	 *
	 * @hocked 'italystrap_after_entry_content' - 30
	 */
	public function author_info_content() {

		if ( 'single' !== CURRENT_TEMPLATE_SLUG && 'page' !== CURRENT_TEMPLATE_SLUG ) {
			return;
		}
	
		$this->get_template_part( 'templates/parts/author', 'info' );
	}

	/**
	 * Function description
	 */
	public function author_info() {

		// if ( ! in_array( CURRENT_TEMPLATE_SLUG, array( 'author', 'single', 'page' ), true ) ) {
		// 	return;
		// }

		if ( 'author' !== CURRENT_TEMPLATE_SLUG ) {
			return null;
		}
	
		$this->get_template_part( 'templates/parts/author', 'info' );
	
	}

	/**
	 * Function description
	 */
	public function archive_headline() {

		if ( ! in_array( CURRENT_TEMPLATE_SLUG, array( 'archive', 'author', 'search' ), true ) ) {
			return;
		}

		$this->get_template_part( 'templates/parts/archive', 'headline' );
	}

	/**
	 * Append template for content header
	 */
	public function content_header() {
		/**
		 * Get the template for displaing the header's contents (header and nav tags)
		 */
		$this->get_template_part( 'templates/parts/header', 'image' );
	}

	/**
	 * Append template for content header
	 * This is in test version.
	 */
	public function navbar_top() {

		if ( ! has_nav_menu( 'info-menu' ) || ! has_nav_menu( 'social-menu' ) ) {
			return;
		}
		/**
		 * Get the template for displaing the header's contents (header and nav tags)
		 */
		$this->get_template_part( 'templates/parts/navbar', 'top' );
	}

	/**
	 * Function description
	 */
	public function pagination() {

		// if ( 'page' !== CURRENT_TEMPLATE_SLUG && 'single' !== CURRENT_TEMPLATE_SLUG ) {
		// 	return null;
		// }
	
		bootstrap_pagination();
	}

	/**
	 * Do Footer
	 */
	public function do_footer( $value = '' ) {

		$this->get_template_part( 'templates/parts/footer-widget-area' );
		$this->get_template_part( 'templates/parts/footer-colophon' );

	}

	/**
	 * Render the output.
	 */
	// abstract public function render();
}
