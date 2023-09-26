<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Application\ConfigCurrentTemplateSubscriber;

class CustomizerBodyTagAttributesSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;

    public function getSubscribedEvents(): iterable
    {
        yield 'italystrap_body_attr' => [
            SubscriberInterface::CALLBACK   => $this,
        ];
    }

    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * Used for the breadcrumbs display on customizer with javascript
     */
    public function __invoke(array $attr): array
    {

        if (! \is_customize_preview()) {
            return $attr;
        }

        $attr['data-current-template'] = $this->config->get(ConfigCurrentTemplateSubscriber::TEMPLATE_FILE_NAME);
        return $attr;
    }
}
