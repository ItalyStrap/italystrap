<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Site;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Navigation\UI\Components\Events\NavMenuHeaderContent;
use ItalyStrap\Theme\Application\ThumbnailsSubscriber;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeSupportProvider;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\Theme\Infrastructure\Support;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\View\ViewInterface;

class Logo implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield NavMenuHeaderContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const ATTRIBUTES = 'attributes';

    public const TEMPLATE_NAME = 'site/logo';

    public function __construct(
        private readonly ConfigInterface $config,
        private readonly ViewInterface $view,
        private readonly Support $support,
        private readonly Json $json,
    ) {
    }

    public function shouldDisplay(): bool
    {
        return $this->support->has(ConfigThemeSupportProvider::CUSTOM_LOGO)
            && $this->config->get(ConfigSiteLogoProvider::CUSTOM_LOGO_ID);
    }

    public function __invoke(NavMenuHeaderContent $event): void
    {
        $size_name_registered = (string)$this->config->get(ConfigSiteLogoProvider::BRAND_IMAGE_SIZE);
        $width = (int)$this->config->get(ThumbnailsSubscriber::class . '.' . $size_name_registered . '.width');

        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::ATTRIBUTES => $this->json->encode([
                'width' => $width,
                'shouldSyncIcon' => 'false',
                'className' => 'is-style-default',
            ]),
        ]));
    }
}
