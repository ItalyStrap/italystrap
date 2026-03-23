<?php

namespace ItalyStrap\Experimental;

use ItalyStrap\Event\SubscribersConfigExtension;

class Module
{
    public function __invoke(): iterable
    {
        return [
            SubscribersConfigExtension::SUBSCRIBERS             => [

                ExperimentalCustomizerOptionWithAndPositionSubscriber::class,
                OembedWrapperSubscriber::class,

                ExperimentalHookComponentsDeprecationSubscriber::class,
            ],
        ];
    }
}