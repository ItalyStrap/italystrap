<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use FunctionalTester;

class AssetCest {

	public function _before(FunctionalTester $I) {
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveStylesheetLoaded(FunctionalTester $I) {
		$I->wantTo( 'See the stylesheet loaded' );

		$custom_css_url = $_SERVER["TEST_SITE_WP_URL"] . '/wp-content/themes/italystrap/css/custom.css';

		$I->amOnPage('/');
		$I->seeElement( ['id' => 'index-css'] );
		$I->seeElement( ['id' => 'index-foo-css'] );
		$I->seeElement( 'link', ['href' => $custom_css_url] );
//		$I->seeElement( 'script', ['id' => 'custom-inline-js'] );
	}
}
