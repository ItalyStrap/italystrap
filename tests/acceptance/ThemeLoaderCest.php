<?php 

class ThemeLoaderCest
{
    public function _before(AcceptanceTester $I)
    {
		$I->amOnPage( '/wp-admin' );
		$I->tryToClick( 'Update WordPress Database', '.button-primary' );
		$I->tryToClick( 'Continue', '.button-large' );

//		$I->loginAsAdmin();
//		$I->amOn

		$I->wantTo( 'See the home page of ItalyStrap' );

		$I->amOnPage('/');
		$I->see('ItalyStrap', 'a');
    }

	// tests

	/**
	 * @param AcceptanceTester $I
	 */
	public function tryToTest( AcceptanceTester $I)
	{
		$content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
		$post_id = $I->havePostInDatabase( [
		     'post_title'   => 'A post',
		     'post_content' => $content,
		] );

		codecept_debug( $post_id );

		$I->amOnPage( '/?p=' . $post_id );
		$I->amOnPage( '/a-post' );

//		$I->see('A post');
	}

	public function onSingular( AcceptanceTester $I ) {
		$I->wantTo( 'See if single has come components' );

		$content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
		$post_id = $I->havePostInDatabase( [
			'post_title'	=> 'A post',
//			'post_content'	=> $content,
			'post_type'		=> 'post',
		] );

//		$I->amOnPage("/?p={$post_id}");

//		$I->seeElement( 'h1', ['class' => 'entry-title'] );
//		$I->seeElement( 'div', ['class' => 'entry-content'] );
	}
}
