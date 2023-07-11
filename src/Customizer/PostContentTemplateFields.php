<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;

class PostContentTemplateFields
{
    private \WP_Customize_Manager $manager;
    private ConfigInterface $config;
    private FieldControlFactory $factory;

    public function __construct(
        \WP_Customize_Manager $manager,
        ConfigInterface $config,
        FieldControlFactory $factory
    ) {
        $this->manager = $manager;
        $this->config = $config;
        $this->factory = $factory;
    }

    public function __invoke(): void
    {
        if (! \class_exists('\ItalyStrap\Customizer\Control\Multicheck')) {
            return;
        }

        $prefix = $this->config->get(ConfigThemeProvider::PREFIX);

        $this->manager->add_section(
            self::class,
            [
                'title'         => \__('Post content template', 'italystrap'),
                'panel'         => PanelFields::class,
                'description'   =>
                    \__(
						// phpcs:disable
						'Allows you to customize the post content template for all archive type pages. (Not page and post).',
						// phpcs:enable
                        'italystrap'
                    ),
            ]
        );

        $id_post_content_template = 'post_content_template';
        $this->manager->add_setting(
            $id_post_content_template,
            [
                // 'default'            => $this->config->get(),
                'type'              => 'theme_mod',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            $this->factory->make(
                '\ItalyStrap\Customizer\Control\Multicheck',
                $this->manager,
                "{$prefix}_$id_post_content_template",
                [
                    'label'     => \__('Template content settings', 'italystrap'),
                    'section'   => self::class,
                    'type'      => 'multicheck',
                    'settings'  => $id_post_content_template,
                    'choices'   => require \get_template_directory() . '/config/template-content.php',
                ]
            )
        );
    }
}
