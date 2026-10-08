<?php

declare(strict_types=1);

namespace ItalyStrap\Block;

use ItalyStrap\Block\Application\HiddenBlocksSubscriber;
use ItalyStrap\Block\Infrastructure\BlockContext;
use ItalyStrap\Block\Infrastructure\TemplateSettings;
use ItalyStrap\Block\UI\Region;
use ItalyStrap\Block\UI\WidgetArea;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Event\SubscribersConfigExtension;

/**
 * The blocks a child theme uses to build its block templates on top of the ItalyStrap components.
 */
final class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
                BlockContext::class,
                TemplateSettings::class,
            ],
            SubscribersConfigExtension::SUBSCRIBERS => [
                Region::class,
                WidgetArea::class,
                HiddenBlocksSubscriber::class,
            ],
        ];
    }
}
