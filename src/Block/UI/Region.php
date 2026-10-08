<?php

declare(strict_types=1);

namespace ItalyStrap\Block\UI;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\UI\Components\Footer\Events\Content as FooterContent;
use ItalyStrap\UI\Components\Header\Events\Content as HeaderContent;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Prints a theme region inside a block template.
 *
 * It bridges the block templates to the ItalyStrap components until each region becomes blocks.
 */
final class Region implements SubscriberInterface
{
    public const NAME = 'italystrap/region';

    /**
     * The regions a block template can print, with the event that renders each one.
     */
    public const REGIONS = [
        'header' => HeaderContent::class,
        'footer' => FooterContent::class,
    ];

    private EventDispatcherInterface $dispatcher;

    public function getSubscribedEvents(): iterable
    {
        yield 'init' => $this;
    }

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(): void
    {
        \register_block_type(self::NAME, [
            'attributes'      => [
                'name' => ['type' => 'string', 'default' => ''],
            ],
            'render_callback' => [$this, 'render'],
        ]);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function render(array $attributes): string
    {
        $name = $attributes['name'] ?? '';
        if (!\is_string($name) || !\array_key_exists($name, self::REGIONS)) {
            return '';
        }

        $eventClass = self::REGIONS[$name];
        $event = $this->dispatcher->dispatch(new $eventClass());

        // The component views print block markup, the canvas parses it later and a block template does not.
        return \do_blocks($event instanceof \Stringable ? (string) $event : '');
    }
}
