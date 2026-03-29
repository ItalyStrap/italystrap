<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

class FieldControlFactory
{
    public function make(
        string $class,
        \WP_Customize_Manager $manager,
        string $id,
        array $args = []
    ): \WP_Customize_Control {
        return new $class($manager, $id, $args);
    }
}
