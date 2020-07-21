<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

require_once 'AssetBase.php';

class ScriptTest extends AssetBase
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    	parent::_before();
    }

    protected function _after()
    {
    	parent::_after();
    }

    // tests
    public function testSomeFeature()
    {

    }

	protected function getInstance() {

    	$this->config->all()->willReturn([]);

		$sut = new \ItalyStrap\Asset\Script( $this->getConfig() );
		$this->assertInstanceOf(\ItalyStrap\Asset\Script::class, $sut, '');

		$this->assertSame(1, $this->apply_filters_called, '');
		return $sut;
	}
}