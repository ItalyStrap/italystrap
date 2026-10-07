<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Block\UI;

use ItalyStrap\Block\UI\Region;
use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\UI\Components\Header\Events\Content;
use Prophecy\Argument;

class RegionTest extends UnitTestCase
{
    // phpcs:ignore
    protected function _before()
    {
        parent::_before();
        $this->defineFunction('do_blocks', static fn(string $content): string => 'parsed:' . $content);
    }

    // phpcs:ignore
    protected function _after()
    {
        $this->undefineAllFunction(['do_blocks']);
        parent::_after();
    }

    private function makeInstance(): Region
    {
        return new Region($this->makeDispatcher());
    }

    public function testItShouldPrintTheRegionEventParsedAsBlocks(): void
    {
        $this->dispatcher->dispatch(Argument::type(Content::class))->will(static function (array $args): Content {
            $args[0]->appendContent('<!-- wp:paragraph --><p>Navbar</p><!-- /wp:paragraph -->');
            return $args[0];
        });

        $output = $this->makeInstance()->render(['name' => 'header']);

        $this->assertSame('parsed:<!-- wp:paragraph --><p>Navbar</p><!-- /wp:paragraph -->', $output);
    }

    public function testItShouldPrintNothingForAnUnknownRegion(): void
    {
        $this->dispatcher->dispatch(Argument::any())->shouldNotBeCalled();

        $this->assertSame('', $this->makeInstance()->render(['name' => 'unknown']));
    }
}
