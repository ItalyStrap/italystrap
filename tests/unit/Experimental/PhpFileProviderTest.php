<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Experimental;

use ItalyStrap\Experimental\PhpFileProvider;
use ItalyStrap\Tests\UnitTestCase;
use Prophecy\Argument;

class PhpFileProviderTest extends UnitTestCase
{
    private string $pattern;

	// phpcs:ignore
	protected function _before() {
        parent::_before();
        $this->pattern = 'Should be a pattern';
    }

    protected function getInstance()
    {
        $sut = new PhpFileProvider('pattern', $this->getFinder());
        return $sut;
    }

    /**
     * @test
     */
    public function shouldBeInvokable()
    {
        $this->finder->names(Argument::type('array'))->willReturn(function (...$args) {
            codecept_debug('$args');
            return $this->finder->reveal();
        });

        $this->finder->getIterator()->willReturn(new \ArrayIterator([
            \codecept_data_dir('fixtures/config/parent-theme/config/default.php'),
        ]));

        $expected = require \codecept_data_dir('fixtures/config/parent-theme/config/default.php');

        $sut = $this->getInstance();
        foreach ($sut() as $actual_file_content) {
            $this->assertEquals($expected, $actual_file_content, '');
        }
    }
}
