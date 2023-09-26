<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit\Config;

use ItalyStrap\Tests\UnitTestCase;
use ItalyStrap\Theme\Application\ConfigCurrentTemplateSubscriber;
use Prophecy\Argument;

class ConfigCurrentTemplateSubscriberTest extends UnitTestCase
{
    protected function getInstance(): ConfigCurrentTemplateSubscriber
    {
        return new ConfigCurrentTemplateSubscriber($this->getConfig(), $this->getFileInfoFactory());
    }

    /**
     * @test
     */
    public function itShouldRegister()
    {
        $sut = $this->getInstance();

        $current_template = 'Current template';

        $file_info = $this->prophet->prophesize(\SplFileObject::class);

        $file_info->getBasename()->willReturn('index.php');
        $file_info->getExtension()->willReturn('php');

        $file_info->getBasename(Argument::type('string'))->willReturn('index');
        $file_info->__toString()->willReturn($current_template);

        $this->fileInfoFactory->make($current_template)->willReturn($file_info->reveal());

        $this->config->set(
            ConfigCurrentTemplateSubscriber::TEMPLATE_FILE_NAME,
            'index.php'
        )->shouldbeCalled();

        $this->config->set(
            ConfigCurrentTemplateSubscriber::TEMPLATE_FILE_SLUG,
            'index'
        )->shouldbeCalled();

        $this->assertSame($current_template, $sut($current_template), '');
    }
}
