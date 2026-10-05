<?php

declare(strict_types=1);

namespace ItalyStrap\UI\Components\Posts;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Posts\Events\PostsContent;
use ItalyStrap\View\ViewInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Post implements ComponentInterface, SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield PostsContent::class => $this;

        yield 'post_class' => [
            SubscriberInterface::CALLBACK       => 'filterPostClass',
            SubscriberInterface::PRIORITY       => 10,
            SubscriberInterface::ACCEPTED_ARGS  => 3,
        ];
    }

    public const TEMPLATE_NAME = 'posts/post';

    private ConfigInterface $config;
    private ViewInterface $view;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ConfigInterface $config,
        ViewInterface $view,
        EventDispatcherInterface $dispatcher
    ) {
        $this->config = $config;
        $this->view = $view;
        $this->dispatcher = $dispatcher;
    }

    public function shouldDisplay(): bool
    {
        return true;
    }

    public function __invoke(PostsContent $event): void
    {
        /**
         * This view is rendered once and used as the inner template of `core/post-template`,
         * so nothing specific to a single post can be printed here: the post id and classes
         * are added by `core/post-template` on each item, see filterPostClass().
         */
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
        ]));
    }

    /**
     * @param string[]        $classes
     * @param string|string[] $class
     *
     * @return string[]
     */
    public function filterPostClass(array $classes, $class, int $postId): array
    {
        /**
         * If it has not a post thumbnail just bail out.
         */
        if (! \has_post_thumbnail($postId)) {
            return $classes;
        }

        /**
         * Remove the 'hentry' css class to prevents error in search console
         */
        $classes = \array_values(\array_filter(
            $classes,
            static fn(string $className): bool => 'hentry' !== $className
        ));

        $classes[] = 'post-thumbnail-' . $this->config->get('post_thumbnail_alignment');

        return $classes;
    }
}
