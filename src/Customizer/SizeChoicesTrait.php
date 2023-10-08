<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

trait SizeChoicesTrait
{
    use BuildThumbnailSizeChoicesTrait;

    private function registerSizeChoicesFor(
        string $prefix,
        string $id,
        string $label,
        string $section,
        string $type,
        int $priority
    ): void {
        $this->manager->add_setting(
            $id,
            [
                'default'           => $this->config->get($id),
                'type'              => 'theme_mod',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $this->manager->add_control(
            "{$prefix}_$id",
            [
                'settings'  => $id,
                'label'     => $label,
                'section'   => $section,
                'type'      => $type,
                'priority'  => $priority,
                'choices'   => $this->buildSizeChoices(),
            ]
        );
    }
}
