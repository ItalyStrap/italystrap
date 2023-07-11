<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\AlignmentChoicesTrait;
use ItalyStrap\Config\ConfigCustomHeaderProvider;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Event\EventDispatcherInterface;

class CustomHeaderFields
{
    use SizeChoicesTrait;
    use AlignmentChoicesTrait;

    public const SECTION = 'header_image';

    private \WP_Customize_Manager $manager;
    private ConfigInterface $config;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        \WP_Customize_Manager $manager,
        ConfigInterface $config,
        EventDispatcherInterface $dispatcher
    ) {
        $this->manager = $manager;
        $this->config = $config;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(): void
    {
        $prefix = $this->config->get(ConfigThemeProvider::PREFIX);

        if (\get_theme_mod('custom_header', false)) {
            \remove_theme_mod('custom_header');
        }

        $id_custom_header = ConfigCustomHeaderProvider::CUSTOM_HEADER_ALIGNMENT;
        $this->manager->add_setting(
            $id_custom_header,
            [
                'default'           => $this->config->get($id_custom_header),
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            "{$prefix}_$id_custom_header",
            [
                'label'     => \__('Container width of the header', 'italystrap'),
                'section'   => self::SECTION,
                'type'      => 'select',
                'settings'  => $id_custom_header,
                'choices'   => $this->getHorizontalThumb(),
            ]
        );

//      $id_custom_header_size = 'custom_image_size';
//      $this->registerSizeChoicesFor(
//          $prefix,
//          $id_custom_header_size,
//          \__('Select the size of the cusom image', 'italystrap'),
//          self::SECTION,
//          'select',
//          80
//      );
    }
}
