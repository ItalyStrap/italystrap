<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Customizer\Control\Multicheck;

class LayoutFields
{
    private \WP_Customize_Manager $manager;
    private ConfigInterface $config;

    public function __construct(
        \WP_Customize_Manager $manager,
        ConfigInterface $config
    ) {
        $this->manager = $manager;
        $this->config = $config;
    }

    public function __invoke(): void
    {
        $prefix = $this->config->get(ConfigThemeProvider::PREFIX);

        $this->manager->add_section(
            'italystrap_layout_options',
            [
                'title'         => \__('Layout', 'italystrap'), // Visible title of section.
                'panel'         => PanelFields::class,
				// phpcs:disable
				'description'	=> \__( 'Allows you to customize the layout for all archive type pages. (Not page and post).', 'italystrap' ),
				// phpcs:enable
            ]
        );

        /**
         * Container Width
         */
        $this->manager->add_setting(
            'container_width',
            [
                'default'           => $this->config->get('container_width'),
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            'italystrap_container_width',
            [
                'label'     => \__('Container width (Global)', 'italystrap'),
                'section'   => 'italystrap_layout_options',
                'type'      => 'radio',
                'settings'  => 'container_width',
                'choices'   => \apply_filters('italystrap_theme_width', []),
            ]
        );

        /**
         * Container Width of the header
         */
        $this->manager->add_setting(
            'site_layout',
            [
                'default'           => $this->config->get('content_sidebar'),
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            'italystrap_site_layout',
            [
                'label'     => \__('Layout (Global)', 'italystrap'),
                'section'   => 'italystrap_layout_options',
                'type'      => 'radio',
                'settings'  => 'site_layout',
                'choices'   => require \get_template_directory() . '/config/layout.php',
            ]
        );
    }
}
