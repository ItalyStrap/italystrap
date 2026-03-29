<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Elements;

use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\View\ViewInterface;

class AuthorInfo implements ElementInterface
{
    public const TEMPLATE_NAME = 'elements/author-info';

    public const AVATAR_SIZE = 'avatarSize';
    public const SHOW_BIO = 'showBio';
    public const BYLINE = 'byline';
    public const IS_LINK = 'isLink';
    public const CLASS_NAME = 'className';

    public const DEFAULT = [
        self::AVATAR_SIZE    => 96,
        self::SHOW_BIO       => true,
        self::BYLINE        => '',
        self::IS_LINK        => true,
        self::CLASS_NAME     => 'author-info',
    ];

    private array $attributes = [];

    private ViewInterface $view;
    private Json $json;

    public function __construct(ViewInterface $view, Json $json)
    {
        $this->view = $view;
        $this->json = $json;
    }

    public function withAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function withContext(string $context): void
    {
    }

    public function withContent(string $content): void
    {
    }

    public function __toString()
    {
        return \do_shortcode(
            $this->view->render(self::TEMPLATE_NAME, [
                self::ATTR => $this->json->encode(\array_merge(self::DEFAULT, $this->attributes)),
            ])
        );
    }
}
