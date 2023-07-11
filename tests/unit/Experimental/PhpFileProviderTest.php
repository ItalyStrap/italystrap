<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Experimental\PhpFileProvider;
use Prophecy\Argument;

class PhpFileProviderTest extends \Codeception\Test\Unit
{
    use \ItalyStrap\Tests\BaseUnitTrait;

    private string $pattern;

	// phpcs:ignore
	protected function _before() {
        $this->setUpProphet();
        $this->pattern = 'Should be a pattern';
    }

	// phpcs:ignore
	protected function _after() {
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
