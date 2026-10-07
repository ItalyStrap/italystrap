<?php

declare(strict_types=1);

namespace ItalyStrap\Asset\Application;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use SplFileInfo;

use function add_editor_style;
use function str_replace;

class EditorSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;
    private FinderInterface $finder;
    private GlobalDispatcherInterface $globalDispatcher;

    public function getSubscribedEvents(): iterable
    {
        yield 'admin_init'  => $this;
    }

    public function __construct(ConfigInterface $config, FinderInterface $finder, GlobalDispatcherInterface $dispatcher)
    {
        $this->config = $config;
        $this->finder = $finder;
        $this->globalDispatcher = $dispatcher;
    }

    /**
     * Add Custom CSS in visual editor
     *
     * @link http://codex.wordpress.org/Function_Reference/add_editor_style
     * @link https://developer.wordpress.org/reference/functions/add_editor_style/
     *
     * Find out issue with path for fonts
     * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
     * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
     */
    public function __invoke(): void
    {
        $editor_style = null;
        foreach ($this->finder as $file) {
            $editor_style = $file;
            break;
        }

        if (! $editor_style instanceof SplFileInfo) {
            return;
        }

        // The path as found, not the real path: a symlinked theme folder would no longer match its directory.
        $style_url = $this->url(\str_replace('\\', '/', $editor_style->getPathname()));

        $arg = (array)$this->globalDispatcher->filter('italystrap_visual_editor_style', [ $style_url ]);

        add_editor_style($arg);
    }

    /**
     * The URL of a file in the child or in the parent theme, the child is checked first.
     */
    private function url(string $path): string
    {
        $directories = [
            ConfigThemeProvider::STYLESHEET_DIR => ConfigThemeProvider::STYLESHEET_DIR_URI,
            ConfigThemeProvider::TEMPLATE_DIR => ConfigThemeProvider::TEMPLATE_DIR_URI,
        ];

        foreach ($directories as $directory_key => $uri_key) {
            $directory = \str_replace('\\', '/', (string) $this->config->get($directory_key));

            if ($directory === '' || ! \str_starts_with($path, $directory . '/')) {
                continue;
            }

            return (string) $this->config->get($uri_key) . \substr($path, \strlen($directory));
        }

        return $path;
    }
}
