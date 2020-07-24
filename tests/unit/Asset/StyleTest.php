<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use ItalyStrap\Asset\AssetOld;
use ItalyStrap\Asset\StyleOld;

require_once 'AssetBase.php';

class StyleTest extends AssetBase {

	protected function getInstance() {
		$sut = new StyleOld( $this->getConfig() );
		$this->assertInstanceOf( AssetOld::class, $sut, '');
		return $sut;
	}
}
