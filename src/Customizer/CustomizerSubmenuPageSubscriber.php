<?php

declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Customizer\Fields\PanelFields;
use ItalyStrap\Event\SubscriberInterface;

class CustomizerSubmenuPageSubscriber implements SubscriberInterface
{
    public function getSubscribedEvents(): iterable
    {
        yield 'admin_menu' => [
            SubscriberInterface::CALLBACK   => '__invoke',
        ];
    }

    /**
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#focusing
     * autofocus[panel|section|control]=ID
     */
    public function __invoke(): void
    {
        \add_submenu_page(
            'italystrap-dashboard',
            \__('Theme Options', 'italystrap'),
            \__('Theme Options', 'italystrap'),
            'edit_theme_options',
            \admin_url('customize.php?autofocus[panel]=' . PanelFields::class)
        );
    }
}
