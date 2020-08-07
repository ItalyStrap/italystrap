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
declare(strict_types=1);

namespace ItalyStrap;

use function ItalyStrap\Factory\get_config;
use function ItalyStrap\HTML\build_site_layout_experimental;

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
	'post_class'	=> function ( array $classes ) {

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

		$config = get_config();
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
	'italystrap_content_attr'			=> function ( array $attr ) {
		$attr['class'] = build_site_layout_experimental('content');
		return $attr;
	},
//	'italystrap_content_attr'			=> [
//		'class'	=> $classes[ $site_layout ]['content'],
//	],

	/**
	 * Attributes for the sidebar element.
	 */
	'italystrap_sidebar_attr'			=> function ( array $attr ) {
		$attr['class'] = build_site_layout_experimental('sidebar');
		return $attr;
	},
//	'italystrap_sidebar_attr'			=> [
//		'class'	=> $classes[ $site_layout ]['sidebar'],
//	],

	/**
	 * Attributes for the sidebar element.
	 * Secondary sidebar does not exist for now and the filter is only for example.
	 */
//	'italystrap_sidebar_secondary_attr'	=> function ( array $attr ) {
//		$attr['class'] = build_site_layout('sidebar_secondary');
//		return $attr;
//	},
//	'italystrap_sidebar_secondary_attr'	=> [
//		'class'	=> $classes[ $site_layout ]['sidebar_secondary'],
//	],

	/**
	 * Post thumbnail size
	 *
	 * @param  string $size The post_thumbnail_size.
	 *
	 * @return string       The post_thumbnail_size full if layout is fullwidth
	 */
	'italystrap_post_thumbnail_size'	=> function ( $size ) {

		$config = get_config();

		/**
		 * @var string $site_layout
		 */
		$site_layout = (string) $config->get( 'site_layout' );

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
	 * Attributes for the sidebars component registered from this theme.
	 */
//	'italystrap_sidebar-1-widget_tag'	=> function ( string $tag ): string {
//		return $tag;
//	},

	/**
	 * Attributes for the sidebars component registered from this theme.
	 */
	'italystrap_sidebar-1-widget_attr'	=> function ( array $attr ): array {
		$attr['id'] = '%1$s';
		$attr['class'] = 'widget %2$s col-sm-6 col-md-12';
		return $attr;
	},

	/**
	 * Attributes for the footer component.
	 */
	'italystrap_footer_attr'	=> [
		'class'	=> 'site-footer',
	],
];