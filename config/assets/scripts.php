<?php

/**
 * The scripts of the front end, a child theme replaces this file with its own config/assets/scripts.php.
 *
 * @see \ItalyStrap\Assets\Application\ConfigAssetsSubscriber
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Handle;
use ItalyStrap\Asset\InlineScript;
use ItalyStrap\Asset\Position;
use ItalyStrap\Asset\Script;
use ItalyStrap\Asset\ScriptLoading;
use ItalyStrap\Assets\Infrastructure\ThemeFile;

use function admin_url;
use function wp_create_nonce;
use function wp_json_encode;

$script = new ThemeFile('build/js/index.js');

return [
    new Script(
        handle: new Handle(CURRENT_TEMPLATE_SLUG),
        source: $script->url(),
        dependencies: $script->dependencies(),
        version: $script->version(),
        loading: new ScriptLoading(inFooter: true),
        inlineScripts: [
            new InlineScript(
                \sprintf('var pluginParams = %s;', (string) wp_json_encode([
                    'ajaxurl' => admin_url('/admin-ajax.php'),
                    'ajaxnonce' => wp_create_nonce('ajaxnonce'),
                ])),
                Position::Before
            ),
        ],
    ),
];
