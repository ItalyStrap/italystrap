<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Acceptance;

use AcceptanceTester;

class ThemeLoaderCest {

	// phpcs:ignore
	public function _before( AcceptanceTester $i ) {
	}

	public function isThemeActive( AcceptanceTester $i ) {
		$i->loginAsAdmin();
		$i->tryToClick( 'Update WordPress Database' );
		$i->tryToClick( 'Update WordPress Database', '.button-primary' );
		$i->tryToClick( 'Update WordPress Database', '.button-large' );
		$i->tryToClick( 'Continue' );
		$i->tryToClick( 'Continue', '.button-large' );

		$i->amOnAdminPage('/themes.php');
		$i->seeElement("div.theme.active[data-slug='italystrap']");
	}
}
