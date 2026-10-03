<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Infrastructure\Config;

use ItalyStrap\Theme\Application\SidebarsSubscriber as S;

class ConfigSidebarProvider
{
    public const SIDEBAR_PRIMARY = 'sidebar-1';
    public const FOOTER_BOX_1 = 'footer-box-1';
    public const FOOTER_BOX_2 = 'footer-box-2';
    public const FOOTER_BOX_3 = 'footer-box-3';
    public const FOOTER_BOX_4 = 'footer-box-4';

    public const FOOTERS = [
        self::FOOTER_BOX_1,
        self::FOOTER_BOX_2,
        self::FOOTER_BOX_3,
        self::FOOTER_BOX_4,
    ];

    public function __invoke(): iterable
    {
        return [
            S::class => [
                self::SIDEBAR_PRIMARY       => [
                    S::NAME             => \__('Sidebar', 'italystrap'),
                    S::ID               => 'sidebar-1',
                ],

                self::FOOTER_BOX_1  => [
                    S::NAME             => \__('Footer Box 1', 'italystrap'),
                    S::ID               => 'footer-box-1',
                    S::DESCRIPTION      => \__('Footer box 1 widget area.', 'italystrap'),
                ],

                self::FOOTER_BOX_2  => [
                    S::NAME             => \__('Footer Box 2', 'italystrap'),
                    S::ID               => 'footer-box-2',
                    S::DESCRIPTION      => \__('Footer box 2 widget area.', 'italystrap'),
                ],

                self::FOOTER_BOX_3  => [
                    S::NAME             => \__('Footer Box 3', 'italystrap'),
                    S::ID               => 'footer-box-3',
                    S::DESCRIPTION      => \__('Footer box 3 widget area.', 'italystrap'),
                ],

                self::FOOTER_BOX_4  => [
                    S::NAME             => \__('Footer Box 4', 'italystrap'),
                    S::ID               => 'footer-box-4',
                    S::DESCRIPTION      => \__('Footer box 4 widget area.', 'italystrap'),
                ],
            ],
        ];
    }
}
