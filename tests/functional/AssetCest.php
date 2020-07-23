<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

use FunctionalTester;

class AssetCest {

	public function _before(FunctionalTester $I) {
		$I->loginAsAdmin();
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

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveStylesheetLoadedInEditor(FunctionalTester $I) {
		$I->wantTo( 'See the stylesheet loaded in editor' );

		$randomPostId = $I->havePostInDatabase();

		$I->amOnAdminPage('/post.php?post=' . $randomPostId . '&action=edit');

		$I->seeResponseCodeIs( 200 );
		$I->seeResponseContains('sourceMappingURL=');
		$I->seeResponseContains('editor-style');
		$I->seeResponseContains('block-editor');

//		$I->activatePlugin();
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldActivateChildTheme(FunctionalTester $I) {
		$I->wantTo( 'See the child theme activated' );
		$I->amOnAdminPage('/themes.php');
//		$I->click( '', '' );
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveCommentReply(FunctionalTester $I) {
		$I->wantTo( 'See comment reply' );
		$I->amOnAdminPage('/themes.php');
//		$I->click( '', '' );
		$I->fail('Comment Reply');
	}
}
