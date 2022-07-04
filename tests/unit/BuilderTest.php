<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ArrayIterator;
use Codeception\Test\Unit;
use ItalyStrap\Builders\Builder;
use RuntimeException;
use tad\FunctionMockerLe;

class BuilderTest extends Unit
{

    use BaseUnitTrait;

    // phpcs:ignore
    /**
     * @test
     */
    public function itShouldThrownExceptionIfEventNameIsNotProvided() {
        FunctionMockerLe\define( '__', function ( $text ) {
            return $text;
        } );

        $this->config->getIterator()->willReturn( new ArrayIterator( [
            'some-component' => [
                // event Name not provided
            ],
        ] ) );

        $sut = $this->getInstance();
        $sut->setInjector( $this->getInjector() );

        $this->expectException( RuntimeException::class );
        $sut->build();
    }

    private function getInstance(): Builder {
        $sut = new Builder(
            $this->getView(),
            $this->getConfig(),
            $this->getDispatcher(),
            $this->getInjector()
        );
        $this->assertInstanceOf( Builder::class, $sut, '' );
        return $sut;
    }

    protected function _before() {
        $this->setUpProphet();
        FunctionMockerLe\undefineAll( ['__'] );
    }
}
