<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;

class Functional extends \Codeception\Module
{
	public function seeResponseContains( $text ){
		try {
			$this->assertStringContainsString( $text, $this->getModule( 'WPBrowser' )->_getResponseContent(), "Response contains" );
		} catch (ModuleException $e) {
		}
	}

}
