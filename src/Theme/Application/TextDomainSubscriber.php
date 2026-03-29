<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use ItalyStrap\Config\ConfigInterface as Config;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;

final class TextDomainSubscriber implements SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield 'italystrap_theme_load'   => [
            static::CALLBACK    => $this,
            static::PRIORITY    => 20,
        ];
    }

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __invoke()
    {
        \load_theme_textdomain(
            'italystrap',
            $this->config->get(ConfigThemeProvider::TEMPLATE_DIR) . '/languages'
        );

        /**
         * @TODO Is it good to register the child theme textdomain here?
         */
//      if ( is_child_theme() ) {
//          \load_child_theme_textdomain( 'CHILD', $this->config->get( 'CHILDPATH' ) . '/languages' );
//      }
    }
}
