<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation;

use ItalyStrap\HTML\Attributes;
use ItalyStrap\HTML\Tag;

class NavMenuFallback
{
    private Attributes $attributes;
    private Tag $tag;

    public function __construct(Attributes $attributes, Tag $tag)
    {
        $this->attributes = $attributes;
        $this->tag = $tag;
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
    public function __invoke(array $wp_nav_menu_args): string
    {

        if (! \current_user_can('manage_options')) {
            return '';
        }

        $output = $this->tag->open(
            self::class,
            $wp_nav_menu_args[ NavMenu::CONTAINER ] ?? '',
            [
                'id'    => $wp_nav_menu_args[ NavMenu::CONTAINER_ID ],
                'class' => $wp_nav_menu_args[ NavMenu::CONTAINER_CLASS_NAME ]
            ]
        );

        $output .= \sprintf(
            '<ul%s><li><a href="%s">%s</a></li></ul>',
            $this->attributes->render(
                self::class,
                [
                    'id'    => $wp_nav_menu_args[ NavMenu::MENU_ID ],
                    'class' => $wp_nav_menu_args[ NavMenu::MENU_CLASS_NAME ]
                ]
            ),
            (string)\admin_url('nav-menus.php') ?? '',
            \__('Add a menu', 'italystrap')
        );

        $output .= $this->tag->close(self::class);

        return $output; // XSS ok.
    }
}
