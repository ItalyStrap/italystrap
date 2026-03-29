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
        $event->appendContent($this->view->render(self::TEMPLATE_NAME, [
            EventDispatcherInterface::class => $this->dispatcher,
            'id' => \get_the_ID(),
            'class_names' => \join(' ', $this->classForPostThumbnail())
        ]));
    }

    private function classForPostThumbnail(): array
    {
        $classes = \get_post_class();

        /**
         * If it has not a post thumbnail just bail out.
         */
        if (! has_post_thumbnail()) {
            return $classes;
        }

        /**
         * Remove the 'hentry' css class to prevents error in search console
         */
        foreach ($classes as $key => $class) {
            if ('hentry' === $class) {
                unset($classes[ $key ]);
            }
        }

        $classes[] = 'post-thumbnail-' . $this->config->get('post_thumbnail_alignment');

        return  $classes;
    }
}
