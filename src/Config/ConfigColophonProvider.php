<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Components\Footer\Events\Content;

class ConfigColophonProvider
{
    public const COLOPHON = 'colophon';
    public const COLOPHON_ACTION = 'colophon_action';
    public const COLOPHON_PRIORITY = 'colophon_priority';

    public function __invoke(): iterable
    {
        yield self::COLOPHON => '';
        yield self::COLOPHON_ACTION => Content::class;
        yield self::COLOPHON_PRIORITY => Colophon::EVENT_PRIORITY;
    }
}
