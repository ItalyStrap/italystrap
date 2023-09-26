<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

trait RenderableEventTestTrait
{
    public function testItShouldRender()
    {
        $instance = $this->makeInstance();
        $instance->appendContent('content');
        $this->assertSame('content', (string)$instance, 'It should render the content');
    }

    public function testItShouldAppendToPreviousContent()
    {
        $instance = $this->makeInstance();
        $instance->appendContent('content');
        $instance->appendContent(' content');
        $this->assertSame(
            'content content',
            (string)$instance,
            'It should append to previous content'
        );
    }
}
