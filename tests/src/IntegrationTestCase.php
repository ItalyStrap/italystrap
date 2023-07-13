<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use Auryn\Injector;
use Codeception\TestCase\WPTestCase as TestCase;
use ItalyStrap\Config\ConfigInterface;

class IntegrationTestCase extends TestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    private Injector $injector;
    private ConfigInterface $config;

    public function setUp(): void
    {
        // Before...
        parent::setUp();

        $this->injector = \ItalyStrap\Factory\injector();
        $this->config = $this->injector->make(ConfigInterface::class);
        // Your set up methods here.
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }
}
