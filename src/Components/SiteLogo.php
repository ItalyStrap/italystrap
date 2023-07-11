<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigSiteLogoProvider;
use ItalyStrap\Config\ConfigThemeSupportProvider;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\StdLib\Json\Json;
use ItalyStrap\Theme\Support;
use ItalyStrap\Theme\ThumbnailsSubscriber;
use ItalyStrap\View\ViewInterface;

class SiteLogo implements ComponentInterface, SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_navmenu_header';
    public const EVENT_PRIORITY = 10;

    public const ATTRIBUTES = 'site-logo-attributes';

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $dispatcher;
    private Support $support;
    private Json $json;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $dispatcher,
        Support $support,
        Json $json
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->dispatcher = $dispatcher;
        $this->support = $support;
        $this->json = $json;
    }

    public function shouldDisplay(): bool
    {
        return $this->support->has(ConfigThemeSupportProvider::CUSTOM_LOGO)
            && $this->config->get(ConfigSiteLogoProvider::CUSTOM_LOGO_ID);
    }

    public function display(): void
    {
        $size_name_registered = (string)$this->config->get(ConfigSiteLogoProvider::BRAND_IMAGE_SIZE);
        $width = (int)$this->config->get(ThumbnailsSubscriber::class . '.' . $size_name_registered . '.width');

        $block_attributes = $this->json->encode([
            'width' => $width,
            'shouldSyncIcon' => 'false',
            'className' => 'is-style-default',
        ]);

        echo \do_blocks($this->view->render('misc/site-logo', [
            self::ATTRIBUTES => $block_attributes
        ]));
    }
}
