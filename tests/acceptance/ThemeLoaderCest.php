<?php 

class ThemeLoaderCest
{
    public function _before(AcceptanceTester $I)
    {
    }

	// tests

	/**
	 * @param AcceptanceTester $I
	 */
	public function tryToTest( AcceptanceTester $I)
	{
		$I->wantTo( 'see the home page of ItalyStrap' );

		$I->amOnPage('/');
		$I->see('ItalyStrap', 'a');

		$content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
		$post_id = $I->havePostInDatabase( [
		     'post_title'   => 'A post',
		     'post_content' => $content,
		] );

		$I->amOnPage("/?p={$post_id}");

		$I->see('A post');
	}

	public function onSingularTest( AcceptanceTester $I ) {
		$I->wantTo( 'See if single has come components' );

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
