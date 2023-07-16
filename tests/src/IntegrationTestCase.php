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
        codecept_debug('IntegrationTestCase::_setUp');
        $this->injector = \ItalyStrap\Factory\injector();
        $this->config = $this->injector->make(ConfigInterface::class);
        // Your set-up methods here.
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }
}
