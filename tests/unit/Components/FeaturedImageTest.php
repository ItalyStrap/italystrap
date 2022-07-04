<?php
declare(strict_types=1);

namespace ItalyStrap\Test\Components;

use ItalyStrap\Components\ComponentInterface;
use ItalyStrap\Components\FeaturedImage;
use ItalyStrap\Tests\BaseUnitTrait;

class FeaturedImageTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;

    // tests
    public function testSomeFeature()
    {

    }

    protected function getInstance(): FeaturedImage {
        $sut = new FeaturedImage($this->getConfig(), $this->getView());
        $this->assertInstanceOf(ComponentInterface::class, $sut, '');
        return $sut;
    }
}