<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\UI\Elements;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Infrastructure\Json;
use ItalyStrap\UI\Elements\AuthorInfo;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class AuthorInfoTest extends UnitTestCase
{
    protected function makeInstance(): AuthorInfo
    {
        return new AuthorInfo(
            $this->makeView(),
            new Json()
        );
    }

    public function testItShouldRender()
    {
        $sut = $this->makeInstance();

        $this->view->render(AuthorInfo::TEMPLATE_NAME, Argument::type('array'))->willReturn(AuthorInfo::TEMPLATE_NAME);

        $this->defineFunction('do_shortcode', static function (string $content) {
            Assert::assertEquals(AuthorInfo::TEMPLATE_NAME, $content);
            return 'from do_shortcode';
        });

        $this->assertEquals('from do_shortcode', (string)$sut, '');
    }
}
