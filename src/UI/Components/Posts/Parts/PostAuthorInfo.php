<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\Parts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostContent;
use ItalyStrap\UI\Elements\AuthorInfo;

class PostAuthorInfo implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 70;

    public function getSubscribedEvents(): iterable
    {
        yield PostContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private ConfigInterface $config;
    private AuthorInfo $authorInfo;

    public function __construct(ConfigInterface $config, AuthorInfo $author)
    {
        $this->config = $config;
        $this->authorInfo = $author;
    }

    public function shouldDisplay(): bool
    {
        return \post_type_supports((string)\get_post_type(), 'author')
            && \is_singular()
            && ! \in_array('hide_author', $this->config->get('post_content_template'), true);
    }

    public function __invoke(PostContent $event): void
    {
        $event->appendContent((string)$this->authorInfo);
    }
}
