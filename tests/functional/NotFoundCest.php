<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class NotFoundCest extends FunctionalTestCase
{
    public function itShouldBeOnHomePageWithReadyToPublish(FunctionalTester $i): void
    {
        $i->haveUserCapabilitiesInDatabase(1, [
            'publish_posts' => true,
        ]);

        $i->loginAsAdmin();
        // I have settings to display posts on home page
        $i->haveOptionInDatabase('show_on_front', 'posts');

        $i->amOnPage('/');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
//        $i->seeResponseContains('Ready to publish your first post?');
        $i->makeHtmlSnapshot(__FUNCTION__);
    }

    public function itShouldBeOnSearchPage(FunctionalTester $i): void
    {
        $i->amOnPage('/?s=123');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
        $i->seeResponseContains('Sorry, but nothing matched your search terms.');
    }

    public function itShouldBeOn404Page(FunctionalTester $i): void
    {
        $i->amOnPage('/?p=123');
        $i->seeResponseCodeIs(404);
        $i->dontSee('<!-- wp:');
        $i->seeResponseContains('Nothing Found');
    }
}
