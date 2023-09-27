<?php

declare(strict_types=1);

namespace ItalyStrap\Debug;

use Auryn\Injector;
use ItalyStrap\Debug\View as DebugView;
use ItalyStrap\Empress\AurynConfig;
use ItalyStrap\Experimental\ExperimentalViewFileFinderFactory;
use ItalyStrap\View\ViewInterface;

class Module
{
    public function __invoke(): iterable
    {
        return [
            AurynConfig::SHARING => [
                DebugView::class,
            ],
            AurynConfig::ALIASES => [
                ViewInterface::class => DebugView::class
            ],
            AurynConfig::DEFINITIONS => [
                DebugView::class => [
                    '+view' => static function (string $named_param, Injector $injector): ViewInterface {
                        $finder = (new ExperimentalViewFileFinderFactory())($named_param, $injector);
                        return $injector->make(View::class, [':finder' => $finder]);
                    },
                ],
            ],
        ];
    }
}
