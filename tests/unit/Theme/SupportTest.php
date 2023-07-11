<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Theme;

use ItalyStrap\Tests\BaseUnitTrait;

class SupportTest extends \Codeception\Test\Unit
{
    use BaseUnitTrait;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    private function getInstance(): \ItalyStrap\Theme\Support
    {
        $sut = new \ItalyStrap\Theme\Support();
        return $sut;
    }

    // tests
    public function instanceOk()
    {
        $this->getInstance();
    }
}
