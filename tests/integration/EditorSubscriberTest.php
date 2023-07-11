<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration;

use ItalyStrap\Asset\EditorSubscriber;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Config\ConfigThemeProvider;
use PHPUnit\Framework\Assert;

use function ItalyStrap\Factory\injector;

class EditorSubscriberTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    public function setUp(): void
    {
        // Before...
        parent::setUp();

        // Your set up methods here.
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

    private function makeInstance(): EditorSubscriber
    {
        $sut = injector()->make(EditorSubscriber::class);
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldEnqueue(): void
    {
        $this->makeInstance()->enqueue();
        global $editor_styles;

        Assert::assertIsArray($editor_styles, '');
        Assert::assertNotEmpty($editor_styles, '');

        $stylesheet_dir_uri = (string)injector()
            ->make(ConfigInterface::class)
            ->get(ConfigThemeProvider::STYLESHEET_DIR_URI);

        Assert::assertSame(
            $stylesheet_dir_uri . '/assets/css/editor-style.css',
            $editor_styles[0],
            ''
        );
    }
}
