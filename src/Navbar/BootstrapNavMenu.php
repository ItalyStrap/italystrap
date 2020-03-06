<?php
/**
 * Navigation Menu template functions for Bootstrap CSS
 *
 * @package ItalyStrap\Core
 * @since 1.0.0
 *
 * @since 4.0.0 New class definitions
 */

declare(strict_types=1);

namespace ItalyStrap\Navbar;

use \Walker_Nav_Menu;

/**
 * Create HTML list of nav menu items.
 *
 * @since 1.0.0
 * @uses Walker
 *
 * Original forked from Author: Edward McIntyre - @twittem but with some code changes
 *
 * @todo Attualmente è posibile usare l'attributo e il titolo per inserire le classi
 *       bootstrap per gestire divider, header e disabled ma così non ha senso
 *       usare la sua classe css invece
 * @todo Sarebbe interessante aggiunger un autocomplete con le classi Bootstrap
 *       nel menù admin
 */
class BootstrapNavMenu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$indent = str_repeat( "\t", $depth );

		$atts = array(
			'role'	=> 'menu',
			'class'	=> ( 0 === $depth ) ? 'dropdown-menu sub-menu depth-lvl-' . $depth : 'sub-sub-menu depth-lvl-' . $depth,
		);

		$output .= "\n" . $indent . '<ul' . $this->get_attributes( $atts ) . '>' . "\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string    $output Used to append additional content (passed by reference).
	 * @param \WP_Post  $item   Menu item data object.
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int       $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'depth-el-' . $depth;

		/**
		 * Filter the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param array    $args  An array of arguments.
		 * @param \WP_Post $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$_atts = array();

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 *
		 * The relative classes must set in CSS class input
		 *
		 * @todo Aggiungere la possibilità di poter inserire i pulsanti nel menù
		 * @link http://getbootstrap.com/components/#navbar-buttons
		 */
		if ( 0 === strcasecmp( $classes[0], 'divider' ) && 1 === $depth ) {
			$_atts = array(
				'role'	=> 'presentation',
				'class'	=> 'divider',
			);

			$output .= $indent . '<li' . $this->get_attributes( $_atts ) . '>';
		} elseif ( 0 === strcasecmp( $classes[0], 'dropdown-header' ) && 1 === $depth ) {
			$_atts = array(
				'role'	=> 'presentation',
				'class'	=> 'dropdown-header',
			);

			$output .= $indent . '<li' . $this->get_attributes( $_atts ) . '>' . esc_attr( $item->title );
		} elseif ( strcasecmp( $classes[0], 'disabled' ) === 0 ) {
			$_atts = array(
				'role'	=> 'presentation',
				'class'	=> 'disabled',
			);

			$output .= $indent . '<li' . $this->get_attributes( $_atts ) . '><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {
			$class_names = $value = '';

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

			/**
			 * If item has children and has class dropup add it as a class to the item itself, else ad dropdown
			 *
			 * @link http://getbootstrap.com/components/#dropdowns-example
			 */
			if ( $args->has_children ) {
				$class_names .= $dropdown = ( 'dropup' === $classes[0] ) ? '' : ' dropdown';
			}

			$current_text = '';

			/**
			 * Da fare
			 *
			 * @todo Verificare l'aggiunta di active in tutte le pagine tranne in home
			 *       con tutte le configurazioni possibili.
			 */
			if ( in_array( 'current-menu-item', $classes, true ) && ! is_front_page() ) {
				$class_names .= ' active';
				$current_text = sprintf(
					' <span class="sr-only">%s</span>',
					__( '(current)', 'italystrap' )
				);
			}

			if ( $class_names ) {
				$_atts['class'] = 'nav-item ' . $class_names;
			}

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$_atts['id'] = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );

			$_atts['itemprop'] = 'name';

			$output .= $indent . '<li' . $this->get_attributes( $_atts ) .'>';

			unset( $_atts );

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title )	? $item->attr_title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			/**
			 * If item has_children add atts to a.
			 */
			if ( $args->has_children && 0 === $depth ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'nav-link dropdown-toggle';
			} else {
				$atts['href']			= ! empty( $item->url ) ? $item->url : '';
				$atts['itemprop']		= 'url';
				$atts['class']			= 'nav-link'; // BT4
			}

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			/**
			 * Filter a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string $title The menu item's title.
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output = $args->before;

			/**
			 * This is the new custom field for this nav menu
			 * You can also do this with hook 'wp_setup_nav_menu_item':
			 * function my_custom_field( $menu_item ) {
			 * 		$menu_item->glyphicon = get_post_meta( $menu_item->ID, '_menu_item_glyphicon', true );
			 *
			 * 	return $menu_item;
			 * }
			 * add_filter( 'wp_setup_nav_menu_item', 'my_custom_field' );
			 *
			 * @var string
			 */
			// $glyphicon = get_post_meta( $item->ID, '_menu_item_glyphicon', true );

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->glyphicon ) ) {
				$item_output .= '<a' . $this->get_attributes( $atts ) . '><span' . $this->get_attributes( array( 'class' => $item->glyphicon ) ) . '></span>&nbsp;';
			} else {
				$atts['itemprop'] = 'url';

				$item_output .= '<a' . $this->get_attributes( $atts ) . '>';
			}

			$item_output .= $args->link_before . $title . $args->link_after . $current_text;

			$item_output .=
				$args->has_children && 0 === $depth
				? ' <span' . $this->get_attributes( array( 'class' => 'caret' ) ) . '></span></a>'
				: '</a>';

			$item_output .= $args->after;

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. It is possible to set the
	 * max depth to include all depths, see walk() method.
	 *
	 * This method should not be called directly, use the walk() method instead.
	 *
	 * @since 2.5.0
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments.
	 * @param string $output            Passed by reference. Used to append additional content.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];

		// Display this element.
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Create the attribute string for html element
	 *
	 * @since 4.0.0 ItalyStrap
	 *
	 * @param  array $atts Array with html attribute.
	 * @return string       Return the string with attribute
	 */
	protected static function get_attributes( array $atts = array() ) {
		return \ItalyStrap\HTML\get_attr( 'nav', $atts );
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param  array   $wp_nav_menu_args passed from the wp_nav_menu function.
	 * @return string
	 */
	public static function fallback( $wp_nav_menu_args ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return '';
		}

		$output = '';

		if ( $wp_nav_menu_args['container'] ) {
			$output = sprintf(
				'<%s%s>',
				esc_attr( trim( $wp_nav_menu_args['container'] ) ),
				self::get_attributes(
					[
						'id'	=> $wp_nav_menu_args['container_id'],
						'class'	=> $wp_nav_menu_args['container_class']
					]
				)
			);
		}

		$output .= sprintf(
			'<ul%s><li><a href="%s">%s</a></li></ul>',
			self::get_attributes(
				[
					'id'	=> $wp_nav_menu_args['menu_id'],
					'class'	=> $wp_nav_menu_args['menu_class']
				]
			),
			admin_url( 'nav-menus.php' ),
			__( 'Add a menu', 'italystrap' )
		);

		if ( $wp_nav_menu_args['container'] ) {
			$output .= sprintf(
				'</%s>',
				esc_attr( trim( $wp_nav_menu_args['container'] ) )
			);
		}

		return $output; // XSS ok.
	}
}
