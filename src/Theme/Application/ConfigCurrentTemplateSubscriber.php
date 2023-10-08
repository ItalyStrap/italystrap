<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;

final class ConfigCurrentTemplateSubscriber implements SubscriberInterface
{
    public const TEMPLATE_FILE_NAME = 'current_template_file';
    public const TEMPLATE_FILE_SLUG = 'current_template_slug';

    public function getSubscribedEvents(): iterable
    {
        yield 'template_include'    => [
            self::CALLBACK  => $this,
            self::PRIORITY  => PHP_INT_MAX - 100,
        ];
    }

    private ConfigInterface $config;
    private FileInfoFactoryInterface $fileInfoFactory;

    public function __construct(
        ConfigInterface $config,
        FileInfoFactoryInterface $fileInfoFactory
    ) {
        $this->config = $config;
        $this->fileInfoFactory = $fileInfoFactory;
    }

    public function __invoke(string $current_template = ''): string
    {
        $current_template = $this->fileInfoFactory->make($current_template);
        $base_name = $current_template->getBasename();
        $slug = $current_template->getBasename('.' . $current_template->getExtension());

        !defined('CURRENT_TEMPLATE') && define('CURRENT_TEMPLATE', $base_name);
        !defined('CURRENT_TEMPLATE_SLUG') && define('CURRENT_TEMPLATE_SLUG', $slug);

        $this->config->set(self::TEMPLATE_FILE_NAME, $base_name);
        $this->config->set(self::TEMPLATE_FILE_SLUG, $slug);

        return $current_template->__toString();
    }
}
