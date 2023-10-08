<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigCustomHeaderProvider
{
    public const CUSTOM_HEADER_ALIGNMENT = 'custom_header_alignment';

    public function __invoke(): iterable
    {
        yield self::CUSTOM_HEADER_ALIGNMENT => 'alignfull';
    }
}
