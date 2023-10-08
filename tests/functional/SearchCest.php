<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class SearchCest extends FunctionalTestCase
{
    public function itShouldBeOnSearchPage(FunctionalTester $i): void
    {
        $entityId = $i->havePostInDatabase([
            'post_title' => 'Test Post Title 123',
            'post_content' => '<!-- wp:paragraph -->',
            'post_status' => 'publish',
        ]);

        $i->amOnPage('/?s=Test');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
//        $i->seeResponseContains('Search results for: "Test"');
        $i->seeResponseContains('wp-block-query-title');
        $i->seeResponseContains('Test Post Title 123');
    }
}
