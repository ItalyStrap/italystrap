<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

trait SubscribedEventsAware
{
    public function getSubscribedEvents(): iterable
    {
        yield self::EVENT_NAME => [
            self::CALLBACK => self::DISPLAY_METHOD_NAME,
            self::PRIORITY => self::EVENT_PRIORITY,
        ];
    }
}
