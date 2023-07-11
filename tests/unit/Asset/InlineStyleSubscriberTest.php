<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Components;

use ItalyStrap\Asset\InlineStyleSubscriber;
use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Test\UndefinedFunctionDefinitionTrait;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class InlineStyleSubscriberTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;
    use UndefinedFunctionDefinitionTrait;

    protected function getInstance(): InlineStyleSubscriber
    {
        $sut = new InlineStyleSubscriber($this->getConfig(), $this->getInlineStyleGenerator());
        $this->assertInstanceOf(SubscriberInterface::class, $sut, '');
        return $sut;
    }

    /**
     * @test
     */
    public function itShouldSubscribe()
    {
        $sut = $this->getInstance();

        $this->inlineStyleGenerator->render(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('string')
        )->shouldBeCalled()->willReturn('-test-');

        $this->config->get(ConfigThemeProvider::PREFIX)->willReturn('italystrap');

        $this->defineFunction('wp_strip_all_tags', fn(string $string) => $string);

        $this->expectOutputString(
            '<style id="italystrap-global-styles-inline-css">-test--test--test-</style>'
        );
        $sut->enqueue();
    }
}
