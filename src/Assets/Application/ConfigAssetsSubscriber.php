<?php

declare(strict_types=1);

namespace ItalyStrap\Assets\Application;

use ItalyStrap\Asset\AssetLoader;
use ItalyStrap\Asset\EventName;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\Style;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;

use function ItalyStrap\Config\get_config_file_content_last;

/**
 * Loads the styles of config/assets/styles.php and the scripts of config/assets/scripts.php on the front end.
 *
 * The config files return lists of Style and Script, the child theme file replaces the parent one.
 * The filters receive the lists and return them, a value that is not a Style or a Script is skipped.
 */
final readonly class ConfigAssetsSubscriber implements SubscriberInterface
{
    public const STYLES_EVENT = 'italystrap_config_enqueue_style';
    public const SCRIPTS_EVENT = 'italystrap_config_enqueue_script';

    public function __construct(
        private GlobalDispatcherInterface $dispatcher,
        private AssetLoader $assets,
    ) {
    }

    public function getSubscribedEvents(): iterable
    {
        yield EventName::FRONT_END => 'load';
    }

    public function load(): void
    {
        $this->assets->load(
            ...$this->assetsOf(self::STYLES_EVENT, 'assets/styles'),
            ...$this->assetsOf(self::SCRIPTS_EVENT, 'assets/scripts'),
        );
    }

    /**
     * @return list<Script|Style>
     */
    private function assetsOf(string $eventName, string $configFile): array
    {
        $assets = $this->dispatcher->filter($eventName, get_config_file_content_last($configFile));
        if (!\is_array($assets)) {
            return [];
        }

        return \array_values(\array_filter(
            $assets,
            static fn (mixed $asset): bool => $asset instanceof Script || $asset instanceof Style
        ));
    }
}
