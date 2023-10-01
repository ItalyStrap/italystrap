<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts\NotFound;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigNotFoundProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsNotFoundContent;
use ItalyStrap\UI\Elements\Search;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;

class Content implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 30;
    private Search $searchObj;

    public function getSubscribedEvents(): iterable
    {
        yield PostsNotFoundContent::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    public const TEMPLATE_NAME = 'posts/not-found/content';

    public const CONTENT = 'content';
    public const SEARCH = 'search';

    private ConfigInterface $config;
    private ViewBlockInterface $view;

    private string $search = '';

    public function __construct(
        ConfigInterface $config,
        ViewBlockInterface $view,
        Search $search
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->searchObj = $search;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(PostsNotFoundContent $event): void
    {
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            self::CONTENT => $this->content(),
            self::SEARCH => $this->search,
        ]));
    }

    private function content(): string
    {
        if (\is_home() && \current_user_can('publish_posts')) {
            return \sprintf(
                '%s <a href="%s">%s</a>.',
                \__('Ready to publish your first post?', 'italystrap'),
                \esc_url(\admin_url('post-new.php')),
                \__('Get started here', 'italystrap')
            );
        }

        if (\is_search()) {
            $this->search = (string)$this->searchObj;
            return \__(
                'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                'italystrap'
            );
        }

        $this->search = (string)$this->searchObj;
        return (string)$this->config->get(ConfigNotFoundProvider::CONTENT);
    }
}
