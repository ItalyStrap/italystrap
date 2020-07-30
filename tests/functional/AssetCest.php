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

//		$dev_dir = '';
//
//		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
//			$dev_dir = 'src/'; // Sistemare il path corretto per i font
//		}

//		$custom_css_url = $_SERVER["TEST_SITE_WP_URL"] . \sprintf(
//				'/wp-content/themes/italystrap/assets/css/%scustom.css',
//				$dev_dir
//		);

		$I->amOnPage('/');
		$I->seeElement( ['id' => 'index-css'] );
//		$I->seeElement( 'link', ['href' => $custom_css_url] );
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveScriptLoaded(FunctionalTester $I) {
		$I->wantTo( 'See the script loaded' );

		$I->amOnPage('/');
		$I->seeInSource('italystrap/assets/js/custom.min.js');
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveLocalizedScriptLoaded(FunctionalTester $I) {
		$I->wantTo( 'See the localized script loaded' );

		$I->amOnPage('/');
		$I->seeInSource('var pluginParams');
	}

	/**
	 * @param FunctionalTester $I
	 * @test
	 */
	public function itShouldHaveCommentReply(FunctionalTester $I) {
		$I->wantTo( 'See comment reply' );

		$randomPostId = $I->havePostInDatabase();
		$I->amOnPage( "/?p={$randomPostId}" );
		$I->seeInSource('comment-reply.js');
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
//	public function itShouldActivateChildTheme(FunctionalTester $I) {
//		$I->wantTo( 'See the child theme activated' );
//		$I->amOnAdminPage('/themes.php');
////		$I->click( '', '' );
//	}
}
