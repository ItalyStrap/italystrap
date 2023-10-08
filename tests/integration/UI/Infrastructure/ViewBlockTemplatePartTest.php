<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\UI\Infrastructure;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Infrastructure\ViewBlockTemplatePart;

class ViewBlockTemplatePartTest extends IntegrationTestCase
{
    public function makeInstance()
    {
        return new ViewBlockTemplatePart();
    }

    public function testRender()
    {
        // Create a post for wp_template_part with some blocks
//        $post_id = $this->factory()->post->create([
//            'post_content' => '<!-- wp:paragraph -->',
//            // With a post name of foo/bar
//            'post_name' => 'bar',
//            // The post type is wp_template_part
//            'post_type' => 'wp_template_part',
//        ]);
//
//         $term = \wp_insert_term( 'foo', 'wp_theme' );
//         \wp_set_post_terms( $post_id, $term['term_id'], 'wp_theme' );

        $blockTemplate = new \WP_Block_Template();
        $blockTemplate->content = '<!-- wp:paragraph -->';

        \add_filter(
            'get_block_template',
            function () use ($blockTemplate) {
                return $blockTemplate;
            }
        );

        $sut = $this->makeInstance();

        $actual = $sut->render('foo/bar');
        codecept_debug('$actual');
        codecept_debug($actual);
    }
}
