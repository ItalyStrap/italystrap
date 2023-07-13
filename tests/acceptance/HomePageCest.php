<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Acceptance;

use AcceptanceTester;
use ItalyStrap\Tests\AcceptanceTestCase;

class HomePageCest extends AcceptanceTestCase
{
    public function homePage(AcceptanceTester $i): void
    {
        $i->wantTo('See the home page of ItalyStrap');

        $testPageId = $i->havePageInDatabase([
            'post_title' => 'Home Page',
            'post_content' => 'Lorem ipsum dolor sit amet',
        ]);

        $i->haveOptionInDatabase('show_on_front', 'page');
        $i->haveOptionInDatabase('page_on_front', (string)$testPageId);

        $i->amOnPage('/');
        $i->see('Lorem ipsum dolor sit amet');
    }
}
