<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Asset;

use ItalyStrap\Asset\InlineStyleGenerator;
use ItalyStrap\Tests\UnitTestCase;

class InlineStyleGeneratorTest extends UnitTestCase
{
    protected function getInstance(): InlineStyleGenerator
    {
        $sut = new InlineStyleGenerator($this->getConfig());
        return $sut;
    }

    public function cssProvider()
    {
        yield 'Base' => [
            'a',// $selector,
            'color', // $property,
            'mods_name', // $mod_name,
            '#',// $prefix,
            '',// $postfix
            'ffffff',// $value
            'a{color:#ffffff;}',// Output
        ];
        yield 'Empty' => [
            'a',// $selector,
            'color', // $property,
            'mods_name', // $mod_name,
            '#',// $prefix,
            '',// $postfix
            '',// $value
            '',// Output
        ];
    }

    /**
     * @test
     * @dataProvider cssProvider
     */
    public function itShouldGenerate(
        string $selector,
        string $property,
        string $mod_name,
        string $prefix,
        string $postfix,
        string $value,
        string $output
    ) {
        $sut = $this->getInstance();

        $this->config->get($mod_name)->shouldBeCalledOnce()->willReturn($value);

        $css = $sut->render(
            $selector,
            $property,
            $mod_name,
            $prefix,
            $postfix
        );
        $this->assertSame($output, $css, '');
    }
}
