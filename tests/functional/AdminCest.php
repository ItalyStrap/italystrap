<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;

class AdminCest {

	// phpcs:ignore
	public function _before(FunctionalTester $i) {
	}

	/**
	 * @param FunctionalTester $i
	 */
	public function itShouldLogin(FunctionalTester $i) {
		$i->loginAsAdmin();
//		$i->tryToClick( 'Update WordPress Database', '.button-primary' );
//		$i->tryToClick( 'Continue', '.button-large' );

//		$i->tryToClick( 'Update WordPress Database' );
//		$i->tryToClick( 'Update WordPress Database', '.button-primary' );
//		$i->tryToClick( 'Update WordPress Database', '.button-large' );
//		$i->tryToClick( 'Continue' );
//		$i->tryToClick( 'Continue', '.button-large' );
		$i->amOnAdminPage('/');
		$i->see('Dashboard');
	}
}
