<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Support;

final readonly class SupportSubscriber implements SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield 'italystrap_theme_load'   => [
            static::CALLBACK    => $this,
            static::PRIORITY    => 20,
        ];
    }

    public function __construct(private ConfigInterface $config, private Support $support)
    {
    }

    /**
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support
     */
    public function __invoke(): void
    {
        foreach ((array) $this->config->get(self::class) as $feature => $parameters) {
            if (\is_string($parameters)) {
                $this->support->add($parameters);
                continue;
            }

            $this->support->add($feature, $parameters);
        }
    }
}
