<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Asset\Application;

use ItalyStrap\Asset\Application\EditorSubscriber;
use ItalyStrap\Tests\Shared\Asset\Application\EditorSubscriberTestTrait;
use ItalyStrap\Tests\UnitTestCase;

class EditorSubscriberTest extends UnitTestCase
{
    use EditorSubscriberTestTrait;

    public function makeIntstance(): EditorSubscriber
    {
        return new EditorSubscriber(
            $this->makeConfig(),
            $this->makeFinder(),
            $this->makeGlobalDispatcher()
        );
    }
}
