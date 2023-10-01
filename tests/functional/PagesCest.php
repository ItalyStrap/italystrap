<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class PagesCest extends FunctionalTestCase
{
    public function itShouldBeOnSearchPage(FunctionalTester $i): void
    {
        $i->amOnPage('/?s=123');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
        $i->seeResponseContains('Sorry, but nothing matched your search terms.');
        $i->makeHtmlSnapshot('search');
    }

    public function itShouldBeOn404Page(FunctionalTester $i): void
    {
        $i->amOnPage('/?p=123');
        $i->seeResponseCodeIs(404);
        $i->dontSee('<!-- wp:');
        $i->seeResponseContains('Nothing Found');
        $i->makeHtmlSnapshot('404');
    }

    public function itShouldBeOnHomePage(FunctionalTester $i): void
    {
        $i->amOnPage('/');
        $i->seeResponseCodeIs(200);
        $i->dontSee('<!-- wp:');
//        $i->seeResponseContains('Hello world!');
        $i->makeHtmlSnapshot('home');
    }

//    public function itShouldBePreviewPage(FunctionalTester $i)
//    {
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
//    }

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

        $i->makeHtmlSnapshot('sample');
    }
}
