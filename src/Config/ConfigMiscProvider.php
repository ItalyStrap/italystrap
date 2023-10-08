<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigMiscProvider
{
    public function __invoke(): iterable
    {
        return [
            /**
             * Layout configuration
             * It's still in alpha version
             */
            //( is_customize_preview() ? get_theme_mod('site_layout') : $this->theme_mods['site_layout'] );
            // https://core.trac.wordpress.org/ticket/24844
            'site_layout'                   => (string) \apply_filters('theme_mod_site_layout', 'content_sidebar'),

            'container_width'               => 'container', // container-fluid.


            'post_content_template'         => '',
            'breadcrumbs_show_on'           => '',
        ];
    }
}
