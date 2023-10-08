<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class LoopsPagesCest extends FunctionalTestCase
{
    public function archivePageWithManyPosts(FunctionalTester $i): void
    {
        $ids = $i->haveManyPostsInDatabase(20, [
            'post_title' => 'Test Post Title {{n}}',
            'post_content' => '<!-- wp:paragraph -->',
            'post_status' => 'publish',
        ]);

        foreach ($ids as $id) {
            $i->haveTermRelationshipInDatabase($id, 1);
        }

        $i->amOnPage('/?cat=1');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
        $i->see('Category:');

        // I can see all posts created
        $i->seeNumberOfElements('.entry-title', 10);

        // I can see the pagination
        $i->seeNumberOfElements('.wp-block-query-pagination-numbers', 1);
    }
}
