<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Elements;

interface ElementInterface extends \Stringable
{
    public const ATTR = 'attributes';
    public const CONTEXT = 'context';
    public const CONTENT = 'content';

    public function withAttributes(array $attributes): void;

    public function withContext(string $context): void;

    public function withContent(string $content): void;
}
