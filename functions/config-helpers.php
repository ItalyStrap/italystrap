<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Experimental\ExperimentalConfigFilesFinderFactory;
use SplFileObject;

use function array_filter;
use function is_null;

/**
 * This return the config from child if is active
 * otherwise it returns a config from the parent
 * @param  string $name
 * @return array
 */
function get_config_file_content_last(string $name): array
{

    /** @var array<int, SplFileObject> $files */
    $files = (new ExperimentalConfigFilesFinderFactory())()->allFiles($name);
    $last_key = \array_key_last($files);

    $config_file_content = require $files[ $last_key ];

    /**
     * removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
     * https://php.net/manual/en/function.array-filter.php#111091
     */
    return array_filter($config_file_content, fn($val) => ! is_null($val));
}
