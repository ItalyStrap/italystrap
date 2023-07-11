<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\WPUnit\Theme;

use ItalyStrap\Tests\WPTestCase;
use ItalyStrap\Theme\PostTypeSupportSubscriber;

/**
 * @method static assertArrayHasKey(string $string, array $all_post_type_support, string $string1)
 * @method assertInstanceOf(string $class, PostTypeSupportSubscriber $sut, string $string)
 */
class TypeSupportTest extends WPTestCase
{
    protected function getInstance()
    {
        $sut = new PostTypeSupportSubscriber($this->config);
        $this->assertInstanceOf(PostTypeSupportSubscriber::class, $sut, '');
        return $sut;
    }

    /**
     *
     */
    public function itShouldRegister()
    {

        $sut = $this->getInstance();

        $sut();

        $all_post_type_support = \get_all_post_type_supports('post');

        self::assertArrayHasKey('post_navigation', $all_post_type_support, '');
        self::assertArrayHasKey('entry-meta', $all_post_type_support, '');
    }
}
