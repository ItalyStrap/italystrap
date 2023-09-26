<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Empress\Injector;

class ConfigProviderExtension implements Extension
{
    private ConfigInterface $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function name(): string
    {
        return self::class;
    }

    public function execute(AurynConfigInterface $application)
    {
        $application->walk(self::class, $this);
    }

    public function __invoke(string $class, $index_or_optionName, Injector $injector): void
    {
        $config_object = $injector->share($class)->make($class);
        if (\is_callable($config_object)) {
            $this->config->merge($injector->execute($config_object));
        }
    }
}
