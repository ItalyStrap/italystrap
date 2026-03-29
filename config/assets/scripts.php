<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Asset\Asset;
use ItalyStrap\Asset\Script;

use function admin_url;
use function wp_create_nonce;

return [
    [
        Asset::HANDLE               => CURRENT_TEMPLATE_SLUG,
        \ItalyStrap\Asset\ConfigBuilder::FILE_NAME => 'build/js/index.js',
        Asset::IN_FOOTER            => true,
        Asset::LOCALIZE             => [
            Script::OBJECT_NAME => 'pluginParams',
            Script::PARAMS      => [
                'ajaxurl'       => admin_url('/admin-ajax.php'),
                'ajaxnonce'     => wp_create_nonce('ajaxnonce'),
                // 'api_endpoint'   => site_url( '/wp-json/rest/v1/' ),
            ],
        ],
    ],
];
