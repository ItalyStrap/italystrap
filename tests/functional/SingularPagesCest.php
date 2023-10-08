<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class SingularPagesCest extends FunctionalTestCase
{
    public function pagesShouldNotHaveBlockSyntax(FunctionalTester $i): void
    {
        $entityId = $i->havePostInDatabase([
            'post_title' => 'Test Post Title',
            'post_content' => '<!-- wp:paragraph -->',
            'post_status' => 'publish',
        ]);

        $i->amOnPage('/?p=' . $entityId);

        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
        $i->see('Test Post Title');
    }

    public function itShouldBePreviewPage(FunctionalTester $i)
    {
//        $entityId = $i->havePostInDatabase([
//            'post_title' => 'Test Post Title',
//            'post_content' => '<!-- wp:paragraph -->',
//            'post_status' => 'draft',
//        ]);
//        $i->amOnPage('/?p=' . $entityId . '&preview=true');
//        $i->seeResponseCodeIs(200);
//        $i->dontSee('<!-- wp:');
//        $i->seeResponseContains('Note: You are previewing this post. This post has not yet been published.');
//        $i->makeHtmlSnapshot('preview');
    }
}
