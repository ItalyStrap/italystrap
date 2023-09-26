<?php

declare(strict_types=1);

namespace ItalyStrap\Headers;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Navigation\UI\Components\Navbar;
use ItalyStrap\Navigation\UI\Components\NavMenuPrimary;
use ItalyStrap\Navigation\UI\Components\NavMenuSecondary;
use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\open_tag_e;

/** @var ConfigInterface $config */
$config = $this;

/** @var Navbar $navbar */
$navbar = $config->get(Navbar::class);

/** @var NavMenuPrimary $nav_menu_primary */
$nav_menu_primary = $config->get(NavMenuPrimary::class);

/** @var NavMenuSecondary $nav_menu_secondary */
$nav_menu_secondary = $config->get(NavMenuSecondary::class);


$number = \esc_attr($config->get('number', \rand()));
$navbar_id = 'italystrap-menu-' . $number;


open_tag_e('nav_container', 'div', [
    'id'    => 'main-navbar-container-' . $navbar_id,
    'class' => sprintf(
        'navbar-wrapper %s',
        $config->get('mods.navbar.nav_width')
    ),
]);

    open_tag_e('navbar_container', 'nav', [
    //        'class'     => 'navbar navbar-expand-lg navbar-light bg-light',
        'class'     => \sprintf(
            'navbar %s %s',
            $config->get('mods.navbar.type'),
            $config->get('mods.navbar.position')
        ),
        'role'      => 'navigation',
        'itemscope' => true,
        'itemtype'  => 'https://schema.org/SiteNavigationElement',
    ]);

        /**
         * This was "'last_container'"
         */
        open_tag_e('nav-inner-container', 'div', [
            'id' => 'menus-container-' . $number,
            'class' => $config->get('mods.navbar.menus_width'),
        ]);

            /**
             * <a class="navbar-brand" href="<?php echo esc_attr( HOME_URL ); ?>">
             *  <?php echo esc_attr( GET_BLOGINFO_NAME ) ?>
             * </a>
             */
            open_tag_e(
                'navbar_header',
                'div',
                [
                    'class' => 'navbar-header',
                    'itemprop' => 'publisher',
                    'itemscope' => true,
                    'itemtype' => 'https://schema.org/Organization',
                ]
            );

            echo $navbar->get_navbar_brand();

/**
 *  = BS3 navbar-toggle
 * >= BS4 navbar-toggler
 */
            ?>
            <button
                class="navbar-toggler navbar-toggle"
                type="button"
                data-toggle="collapse"
                data-target="#<?php echo $navbar_id ?>"
                aria-controls="<?php echo $navbar_id ?>"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
<!--                <span class="navbar-toggler-icon">&nbsp</span>-->
                <?php echo apply_filters('italystrap_icon_bar', ''); ?>
            </button>
            <?php

            close_tag_e('navbar_header');

            open_tag_e('collapsable_menu', 'div', [
                'id' => $navbar_id,
                'class' => 'navbar-collapse collapse',
            ]);

            $nav_menu_primary->display();
            $nav_menu_secondary->display();

            close_tag_e('collapsable_menu');
            close_tag_e('nav-inner-container');
            close_tag_e('navbar_container');

            close_tag_e('nav_container');
