<?php

const ITALYSTRAP_TESTS_RUNNING = true;

\class_alias(
    \ItalyStrap\Event\GlobalDispatcherInterface::class,
    \ItalyStrap\Event\EventDispatcherInterface::class
);

\class_alias(
    \ItalyStrap\Event\GlobalDispatcher::class,
    \ItalyStrap\Event\EventDispatcher::class
);
