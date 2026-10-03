<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Integration\UI\Infrastructure;

use ItalyStrap\Tests\IntegrationTestCase;
use ItalyStrap\UI\Infrastructure\ViewBlockTemplatePart;

class ViewBlockTemplatePartTest extends IntegrationTestCase
{
    public function makeInstance(): ViewBlockTemplatePart
    {
        return new ViewBlockTemplatePart($this->config);
    }

    public function testSimpleRender()
    {
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
        $this->assertSame('<!-- wp:paragraph -->', $actual);
    }

    public function testRender()
    {
        $stylesheet = \get_stylesheet();

        $post_id = $this->factory()->post->create([
            'post_content' => '<!-- wp:site-title /-->',
            'post_name' => 'bar',
            'post_type' => 'wp_template_part',
        ]);

        $term = \wp_insert_term($stylesheet, 'wp_theme');
        $term_id = \is_wp_error($term)
            ? \get_term_by('name', $stylesheet, 'wp_theme')->term_id
            : $term['term_id'];

        \wp_set_object_terms($post_id, $term_id, 'wp_theme');
        \clean_post_cache($post_id);

        $sut = $this->makeInstance();

        $actual = $sut->render('bar');
        $this->assertSame('<!-- wp:site-title /-->', $actual);
    }
}
