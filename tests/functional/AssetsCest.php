<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class AssetsCest extends FunctionalTestCase
{
    /**
     * @param FunctionalTester $i
     */
    public function itShouldHaveStylesheetLoaded(FunctionalTester $i)
    {
        $i->wantTo('See the stylesheet loaded');

        $i->amOnPage('/');
        $i->seeElement(['id' => 'index-css']);
        $i->seeElement(['id' => 'index-js']);
        $i->seeElement(['id' => 'index-js-extra']);

        $i->seeInSource('italystrap/assets/css/index.min.css');
        $i->seeInSource('italystrap/assets/js/index.min.js');
        $i->seeInSource('var pluginParams');
    }

    public function itShouldHaveCommentReply(FunctionalTester $i)
    {
        $i->wantTo('See comment reply');

        $randomPostId = $i->havePostInDatabase();
        $i->amOnPage("/?p={$randomPostId}");
        $i->seeInSource('comment-reply.min.js');
    }

    public function itShouldHaveStylesheetLoadedInEditor(FunctionalTester $i)
    {
        $i->wantTo('See the stylesheet loaded in editor');

        $randomPostId = $i->havePostInDatabase();
        $i->loginAsAdmin();

        $i->amOnAdminPage('/post.php?post=' . $randomPostId . '&action=edit');

        $i->seeResponseCodeIs(200);
        $i->seeResponseContains('sourceMappingURL=');
        $i->seeResponseContains('editor-style');
        $i->seeResponseContains('block-editor');
    }
}
