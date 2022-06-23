<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Experimental\PhpFileProvider;
use ItalyStrap\Finder\FinderFactory;
use Prophecy\Argument;

class PhpFileProviderTest extends \Codeception\Test\Unit
{

    use \ItalyStrap\Tests\BaseUnitTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

    private \Prophecy\Prophecy\ObjectProphecy $finder;

    private string $pattern;

    protected function _before()
    {
        $this->prophet = new \Prophecy\Prophet;
        $this->finder = $this->prophet->prophesize( \ItalyStrap\Finder\FinderInterface::class );
        $this->pattern = 'Should be a pattern';
    }

    protected function _after()
    {
    }

    protected function getInstance() {
        $sut = new PhpFileProvider('pattern', $this->finder->reveal());
        return $sut;
    }

    /**
     * @test
     */
    public function shouldBeInvokable() {
        $this->finder->names(Argument::type('array'))->willReturn(function (...$args){
            codecept_debug('$args');
            return $this->finder->reveal();
        });

        $this->finder->getIterator()->willReturn(new \ArrayIterator([
            \codecept_data_dir('fixtures/config/parent-theme/config/default.php'),
        ]));

        $expected = require \codecept_data_dir('fixtures/config/parent-theme/config/default.php');

        $sut = $this->getInstance();
        foreach ( $sut() as $actual_file_content ) {
            $this->assertEquals( $expected, $actual_file_content, '');
        }
    }
}