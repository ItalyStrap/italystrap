<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

class BetaFields
{
    public const SECTION = 'beta';

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
        $id_beta = 'beta';

        $this->manager->add_section(
            $id_beta,
            [
                'title'             => \__('Beta version', 'italystrap'),
                'panel'             => PanelFields::class,
                'priority'          => 160,
            ]
        );

        $this->manager->add_setting(
            $id_beta,
            [
                'default'           => $this->config->get($id_beta),
                'type'              => 'theme_mod',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ]
        );

        $this->manager->add_control(
            "{$prefix}_{$id_beta}",
            [
                'label'         => __('Beta version', 'italystrap'),
                'description'       => __('Only if you want use some beta stuff', 'italystrap'),
                'section'       => self::SECTION,
                'settings'      => $id_beta,
                'priority'      => 10,
                'type'          => 'checkbox',
            ]
        );
    }
}
