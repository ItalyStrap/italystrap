<?php

declare(strict_types=1);

namespace ItalyStrap\Navigation\UI\Components;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Support;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Components\Main\Events\Content;

use function ob_get_clean;
use function ob_start;

class Breadcrumbs implements ComponentInterface, SubscriberInterface
{
    public const EVENT_PRIORITY = 10;

    public function getSubscribedEvents(): iterable
    {
        yield Content::class => [
            SubscriberInterface::CALLBACK => $this,
            SubscriberInterface::PRIORITY => self::EVENT_PRIORITY,
        ];
    }

    private GlobalDispatcherInterface $dispatcher;
    private ConfigInterface $config;
    private Support $support;

    public function __construct(
        GlobalDispatcherInterface $dispatcher,
        ConfigInterface $config,
        Support $support
    ) {
        $this->dispatcher = $dispatcher;
        $this->config = $config;
        $this->support = $support;
    }

    public function shouldDisplay(): bool
    {
        return $this->support->has('breadcrumbs')
            && \in_array(
                $this->config->get('current_template_file'),
                \explode(',', $this->config->get('breadcrumbs_show_on', '')),
                true
            )
            && ! \in_array('hide_breadcrumbs', $this->config->get('post_content_template'), true);
    }

    /**
     * @examples:
     * $args = [
     *     'home'   => '<i class="glyphicon glyphicon-home" aria-hidden="true"></i>',
     * ];
     */
    public function __invoke(Content $event): void
    {
        ob_start();
        $this->dispatcher->trigger('do_breadcrumbs', []);
        $event->appendContent((string)ob_get_clean());
    }
}
