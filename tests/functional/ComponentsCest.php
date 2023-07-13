<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Functional;

use FunctionalTester;
use ItalyStrap\Tests\FunctionalTestCase;

class ComponentsCest extends FunctionalTestCase
{
    /**
     * @param FunctionalTester $i
     */
    public function shouldSeeThePostTitleComponent(FunctionalTester $i): void
    {

        $content = implode(' ', array_fill(0, 274, 'lorem'));
        $post_id = $i->havePostInDatabase([
            'post_title'    => 'A post',
//          'post_content'  => $content,
//          'post_type'     => 'post',
        ]);

        $i->amOnPage("/?p={$post_id}");
        $i->see('A post', 'h1');
        $i->see('A post', ['class' => 'entry-title']);

        $page_id = $i->havePageInDatabase([
            'post_title'    => 'A page',
        ]);

        $i->amOnPage("/?p={$page_id}");
        $i->see('A page', 'h1');
        $i->see('A page', ['class' => 'entry-title']);
        $i->see('A page', ['class' => 'wp-block-post-title']);
    }
}
