<?php 

class ThemeLoaderCest
{
    public function _before(AcceptanceTester $I)
    {
    }

	// tests
	public function tryToTest(AcceptanceTester $I)
	{
		$I->wantTo( 'see the home page of ItalyStrap' );

//		$I->amOnPage('/');
//		$I->see('ItalyStrap');

//		 $content = implode( ' ', array_fill( 0, 274, 'lorem' ) );
//		 $post_id = $I->havePostInDatabase( [
//		     'post_title'   => 'A post',
//		     'post_content' => $content,
//		 ] );
//
//		 $I->amOnPage("/?p={$post_id}");

		 // $I->see('A post');
		// $I->see('Ciao mondo');
	}
}
