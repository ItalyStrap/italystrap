<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Elements;

use ItalyStrap\HTML\TagInterface;
use ItalyStrap\View\ViewInterface;

class Figure implements ElementInterface
{
    public const TEMPLATE_NAME = 'elements/figure';
    private ViewInterface $view;

    private array $attributes = [];
    private string $context = '';
    private string $content = '';
    private TagInterface $tag;

    public function __construct(
        ViewInterface $view,
        TagInterface $tag
    ) {
        $this->view = $view;
        $this->tag = $tag;
    }

    public function withAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function withContext(string $context): void
    {
        $this->context = $context;
    }

    public function withContent(string $content): void
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->view->render(self::TEMPLATE_NAME, [
            TagInterface::class => $this->tag,
            self::ATTR => $this->attributes,
            self::CONTEXT => $this->context,
            self::CONTENT => $this->content,
        ]);
    }
}
