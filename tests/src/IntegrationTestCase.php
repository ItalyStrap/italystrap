<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use Auryn\Injector;
use Codeception\TestCase\WPTestCase;
use ItalyStrap\Config\ConfigInterface;

class IntegrationTestCase extends WPTestCase
{
    protected \IntegrationTester $tester;
    protected Injector $injector;
    protected ConfigInterface $config;

    public function setUp(): void
    {
        // Before...
        parent::setUp();

        $this->injector = \ItalyStrap\Factory\injector();
        $this->config = $this->injector->make(ConfigInterface::class);
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }
}
