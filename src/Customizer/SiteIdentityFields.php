<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

class SiteIdentityFields
{
    private \WP_Customize_Manager $manager;

    public function __construct(
        \WP_Customize_Manager $manager
    ) {
        $this->manager = $manager;
    }

    public function __invoke(): void
    {
        $this->manager->get_setting('blogname')->transport = 'postMessage';
        $this->manager->get_setting('blogdescription')->transport = 'postMessage';
    }
}
