<?php

declare(strict_types=1);

namespace ItalyStrap\Asset;

use ItalyStrap\Config\ConfigThemeProvider;
use ItalyStrap\Event\EventDispatcher;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Config\Config;
use ItalyStrap\Finder\Finder;
use SplFileInfo;

use function add_editor_style;
use function realpath;
use function str_replace;

class EditorSubscriber implements SubscriberInterface
{
    private Config $config;
    private Finder $finder;
    private EventDispatcher $dispatcher;

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): iterable
    {
        yield 'admin_init'  => 'enqueue';
    }

    /**
     * Editor constructor.
     * @param Config $config
     * @param Finder $finder
     */
    public function __construct(Config $config, Finder $finder, EventDispatcher $dispatcher)
    {
        $this->config = $config;
        $this->finder = $finder;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Add Custom CSS in visual editor
     *
     * @link http://codex.wordpress.org/Function_Reference/add_editor_style
     * @link https://developer.wordpress.org/reference/functions/add_editor_style/

     * Leggere qui perché forse c'è un problema con i font, non prende il path giusto
     * @link http://codeboxr.com/blogs/adding-twitter-bootstrap-support-in-wordpress-visual-editor
     * @link https://www.google.it/search?q=wordpress+add+css+bootstrap+visual+editor&oq=wordpress+add+css+bootstrap+visual+editor&gs_l=serp.3...893578.895997.0.896668.10.10.0.0.0.3.388.1849.0j1j4j2.7.0....0...1c.1.52.serp..8.2.732.wb3nJL89Fxk
     */
    public function enqueue(): void
    {

        /** @var SplFileInfo $editor_style */
        $editor_style = '';
        foreach ($this->finder as $file) {
            $editor_style = $file;
            break;
        }

        /**
         * @TODO In fase di test bisogna verificare sia il path to url per il child
         *       che per il parent theme, qui per esempio prendo tutto dal child
         *       e dovrebbe fare la fallback sul parent in caso il child non
         *       sia installato
         *      http:://italystrap.test\dir/dir\dir
         */
        $style_url = str_replace(
            (string) realpath((string) $this->config->get(ConfigThemeProvider::STYLESHEET_DIR)),
            (string) $this->config->get(ConfigThemeProvider::STYLESHEET_DIR_URI), // Replace
            $editor_style->getRealPath()
        );

        $style_url = str_replace('\\', '/', $style_url);

        $arg = (array)$this->dispatcher->filter('italystrap_visual_editor_style', [ $style_url ]);

        add_editor_style($arg);
    }
}
