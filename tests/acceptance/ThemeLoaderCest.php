<?php 

class ThemeLoaderCest
{
    public function _before( AcceptanceTester $I )
    {
		$I->amOnPage( '/wp-admin' );
		$I->tryToClick( 'Update WordPress Database', '.button-primary' );
		$I->tryToClick( 'Continue', '.button-large' );

		$I->wantTo( 'See the home page of ItalyStrap' );

		$I->amOnPage('/');
		$I->see('ItalyStrap', 'a');
    }

	/**
	 * @param AcceptanceTester $I
	 * @test
	 */
	public function tryToTest( AcceptanceTester $I )
	{
		$content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
		$post_id = $I->havePostInDatabase( [
		     'post_title'   => 'A post',
		     'post_content' => $content,
		] );

		$I->amOnPage( '/?p=' . $post_id );
		$I->see('A post');

		$I->amOnPage( '/a-post' );
		$I->see('A post');

		$I->seeElement( 'h2', ['class' => 'entry-title'] );
		$I->seeElement( 'div', ['class' => 'entry-content'] );
	}

	/**
	 * @test
	 * @param AcceptanceTester $I
	 */
	public function onSingular( AcceptanceTester $I ) {
		$I->wantTo( 'See if single has some components' );

		$content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
		$post_id = $I->havePostInDatabase( [
			'post_title'	=> 'A post',
//			'post_content'	=> $content,
			'post_type'		=> 'post',
		] );

		$I->amOnPage("/?p={$post_id}");

		$I->seeElement( 'h1', ['class' => 'entry-title'] );
		$I->seeElement( 'div', ['class' => 'entry-content'] );
	}
}
