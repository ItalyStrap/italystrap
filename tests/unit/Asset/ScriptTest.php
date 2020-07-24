<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\ScriptOld;

require_once 'AssetBase.php';

class ScriptTest extends AssetBase {

	protected function getInstance() {
		$sut = new ScriptOld( $this->getConfig() );
		$this->assertInstanceOf( ScriptOld::class, $sut, '');
		return $sut;
	}
}
