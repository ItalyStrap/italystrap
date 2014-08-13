<?php
/**
 * Register your own Custom Post Type in this file
 *
 * Remeber to regenerate permalink in /wp-admin/options-permalink.php?settings-updated=true
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @link http://melchoyce.github.io/dashicons/
 * 
 * @package ItalyStrap
 * @since 1.0.0
 */
function custom_post_type() {
	$labels = array(
		'name'                => _x( 'Products', 'Post Type General Name', 'ItalyStrap' ),
		'singular_name'       => _x( 'Products', 'Post Type Singular Name', 'ItalyStrap' ),
		'menu_name'           => __( 'Products', 'ItalyStrap' ),
		'parent_item_colon'   => __( 'Parent products:', 'ItalyStrap' ),
		'all_items'           => __( 'All products', 'ItalyStrap' ),
		'view_item'           => __( 'View products', 'ItalyStrap' ),
		'add_new_item'        => __( 'Add new product', 'ItalyStrap' ),
		'add_new'             => __( 'Add new product', 'ItalyStrap' ),
		'edit_item'           => __( 'Edit products', 'ItalyStrap' ),
		'update_item'         => __( 'Update products', 'ItalyStrap' ),
		'search_items'        => __( 'Search products', 'ItalyStrap' ),
		'not_found'           => __( 'Products not found', 'ItalyStrap' ),
		'not_found_in_trash'  => __( 'No products found in trash', 'ItalyStrap' ),
	);

	$supports_array = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'custom-fields',
		'comments', // (also will see comment count balloon on edit screen) 
		'revisions', // (will store revisions)
		'page-attributes', // (menu order, hierarchical must be true to show Parent option) 
		'post-formats'
	);

	$args = array(
		'label'               => __( 'products', 'ItalyStrap' ),
		'description'         => __( 'Information pages of prodotti - <strong>insert here</strong> any description of custom post page', 'ItalyStrap' ),
		'labels'              => $labels,
		'supports'            => $supports_array,
		'taxonomies'          => array( 'category', 'post_tag', 'Slide' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-cart',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => true,
		'capability_type'     => 'page',
	);

	register_post_type( 'prodotti', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );
?>