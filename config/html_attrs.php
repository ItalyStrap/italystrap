<?php
/**
 * ===========================================================
 *
 * Configuration file for adding attributes to relative hooks
 *
 * The hooks will returns at first argument an array, optionally
 * if the hook is created from \ItalyStrap\HTML\get_attr()
 * i will pass 3 arguments, (array) $attr, (string) $context and $data
 *
 * @example:
 * [
 * 	'filter_name'	=> [...filter_attributes],
 *  'filter_name'	=> callable()
 * ]
 *
 * ===========================================================
 */

use \ItalyStrap\Factory;

/**
 * @var \ItalyStrap\Config\Config $config
 */
$config = Factory\get_config();

/**
 * @var string $site_layout
 */
$site_layout = (string) $config->get( 'site_layout' );

/**
 * @var array $classes
 */
$classes = [
	'full_width'				=> [
		'content'			=> $config->get('full_width'),
		'sidebar'			=> '',
		'sidebar_secondary'	=> '',
	],
	'content_sidebar'			=> [
		'content'			=> $config->get('content_class'),
		'sidebar'			=> $config->get('sidebar_class'),
		'sidebar_secondary'	=> '',
	],
	'content_sidebar_sidebar'	=> [
		'content'			=> 'col-md-7',
		'sidebar'			=> 'col-md-3',
		'sidebar_secondary'	=> 'col-md-2',
	],
	'sidebar_content_sidebar'	=> [
		'content'			=> 'col-md-7 col-md-push-3',
		'sidebar'			=> 'col-md-3 col-md-pull-7',
		'sidebar_secondary'	=> 'col-md-2',
	],
	'sidebar_sidebar_content'	=> [
		'content'			=> 'col-md-7 col-md-push-5',
		'sidebar'			=> 'col-md-3 col-md-pull-7',
		'sidebar_secondary'	=> 'col-md-2 col-md-pull-10',
	],
	'sidebar_content'			=> [
		'content'			=> $config->get('content_class') . '  col-md-push-4',
		'sidebar'			=> $config->get('sidebar_class') . '  col-md-pull-8',
		'sidebar_secondary'	=> '',
	],
];

/**
 * Make sure to apply this filters at wp action.
 *
 * @return array Return the filters with the value to append to.
 */
return [

	/**
	 * Append the CURRENT_TEMPLATE_SLUG to body_class
	 */
	'body_class'	=> function ( array $classes ) {
		$classes[] = CURRENT_TEMPLATE_SLUG;
		return  $classes ;
	},

	/**
	 * This is the <article ...> HTML attr.
	 */
	'post_class'	=> function ( array $classes ) use ( $config ) {

		/**
		 * Remove the 'hentry' css class to prevents error in search console
		 */
		foreach ( $classes as $key => $class ) {
			if( 'hentry' === $class ) {
				unset( $classes[ $key ] );
			}
		}

		/**
		 * If has not a post thumbnail just bail out.
		 */
		if ( ! has_post_thumbnail() ) {
			return $classes;
		}

		$classes[] = 'post-thumbnail-' . $config->get( 'post_thumbnail_alignment' );

		return  $classes;
	},

	/**
	 * Attributes for the body element.
	 */
	'italystrap_body_attr'			=> [
		'class'	=> join( ' ', get_body_class() ),
	],

	/**
	 * Attributes for the body element.
	 */
	'italystrap_wrapper_attr'			=> [
		'class'	=> 'wrapper',
	],

	/**
	 * Attributes for the icon bar.
	 */
	'italystrap_icon_bar'			=> function ( string $icon ) : string {
		$icon = '<span class="icon-bar">&nbsp</span><span class="icon-bar">&nbsp</span><span class="icon-bar">&nbsp</span>';
		return $icon;
	},

	/**
	 * Attributes for the content element.
	 */
//	'italystrap_index-container_tag'			=> function ( ...$args ) {
//		return $args[0];
//	},

	/**
	 * Attributes for the content element.
	 */
	'italystrap_index-container_attr'			=> [
		'class'	=> 'container',
	],

	/**
	 * Attributes for the content element.
	 */
//	'italystrap_index-row_tag'			=> function ( ...$args ) {
//		return $args[0];
//	},

	/**
	 * Attributes for the content element.
	 */
	'italystrap_index-row_attr'			=> [
		'class'	=> 'row',
	],

	/**
	 * Attributes for the content element.
	 */
	'italystrap_content_tag'			=> function ( ...$args ) {
		return $args[0];
	},

	/**
	 * Attributes for the content element.
	 */
	'italystrap_content_attr'			=> [
		'class'	=> $classes[ $site_layout ]['content'],
	],

	/**
	 * Attributes for the sidebar element.
	 */
	'italystrap_sidebar_attr'			=> [
		'class'	=> $classes[ $site_layout ]['sidebar'],
	],

	/**
	 * Attributes for the sidebar element.
	 * Secondary sidebar does not exist for now and the filter is only for example.
	 */
	'italystrap_sidebar_secondary_attr'	=> [
		'class'	=> $classes[ $site_layout ]['sidebar_secondary'],
	],

	/**
	 * Post thumbnail size
	 *
	 * @param  string $size The post_thumbnail_size.
	 *
	 * @return string       The post_thumbnail_size full if layout is fullwidth
	 */
	'italystrap_post_thumbnail_size'	=> function ( $size ) use ( $site_layout ) {

		if ( 'full_width' === $site_layout ) {
			return 'full-width';
		}

		if ( is_page_template( 'full-width.php' ) ) {
			return 'full-width';
		}

		return $size;
	},

	/**
	 * Attributes for the preview component.
	 */
	'italystrap_preview_attr'	=> [
		'class' => 'alert alert-info'
//		'class' => 'alert alert-danger',
//		'style'	=> 'background-color: red; padding: 1rem;',
	],

	/**
	 * Attributes for the entry content component.
	 */
	'italystrap_entry_content_attr'	=> [
		'class' => 'entry-content'
	],

	/**
	 * Attributes for the entry content component.
	 */
	'italystrap_post_thumbnail_attr'	=> function ( array $attr ) {

		$attr['class'] = $attr['class'] . ' img-responsive img-fluid';

		return $attr;
	},

	/**
	 * Attributes for the footer component.
	 */
	'italystrap_footer_attr'	=> [
		'class'	=> 'site-footer',
	],
];