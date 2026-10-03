<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Archive;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Events\Content;
use ItalyStrap\UI\Elements\AuthorInfo;

use function is_author;

class ArchiveAuthorInfo implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private AuthorInfo $authorInfo;

    public function __construct(AuthorInfo $info)
    {
        $this->authorInfo = $info;
    }

    public function shouldDisplay(): bool
    {
        return is_author();
    }

    public function __invoke(Content $event): void
    {
        $event->appendContent((string)$this->authorInfo);
    }
}
