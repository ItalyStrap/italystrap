<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

interface Arrayable
{
    /**
     * @return iterable
     */
    public function toArray(): iterable;
}
