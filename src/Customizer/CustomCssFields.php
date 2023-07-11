<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Customizer\Control\Textarea;
use WP_Error;
use WP_Post;

class CustomCssFields
{
    private \WP_Customize_Manager $manager;
    private ConfigInterface $config;
    private FieldControlFactory $control;
    private \WP_Theme $theme;

    public function __construct(
        \WP_Customize_Manager $manager,
        ConfigInterface $config,
        FieldControlFactory $control,
        \WP_Theme $theme
    ) {
        $this->manager = $manager;
        $this->config = $config;
        $this->control = $control;
        $this->theme = $theme;
    }

    public function __invoke(): void
    {

        $custom_css = $this->config->get('custom_css');
        if (! empty($custom_css)) {
            $custom_css = \strip_tags($custom_css);
            /** @var WP_Post|WP_Error Post on success, error on failure. $post */
            $post = \wp_update_custom_css_post($custom_css);
            $this->assertValueIsSaved($post);
            \remove_theme_mod('custom_css');
            \set_theme_mod(self::class, true);
            return;
        }

        if ((bool)$this->config->get(self::class, false)) {
            return;
        }

        $this->manager->add_section(
            self::class,
            [
                'title'             => \__('Additional CSS', 'italystrap'),
                'description'       => \__('Add custom CSS here', 'italystrap'),
                'panel'             => PanelFields::class,
                'theme_supports'    => '',
            ]
        );

        $id_custom_css = 'custom_css';
        $this->manager->add_setting(
            $id_custom_css,
            [
                'default'           => (string)$this->config->get('custom_css'),
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            $this->control->make(
                Textarea::class,
                $this->manager,
                $id_custom_css,
                [
                    'label'         => \__('Custom CSS', 'italystrap'),
                    'description'   => \__('Insert here your custom CSS', 'italystrap'),
                    'section'       => self::class,
                    'settings'      => $id_custom_css,
                ]
            )
        );
    }

    /**
     * @param WP_Post|WP_Error $post
     */
    private function assertValueIsSaved($post): void
    {
        if (! $post instanceof \WP_Error) {
            return;
        }

        throw new \RuntimeException($post->get_error_message(), $post->get_error_code());
    }
}
