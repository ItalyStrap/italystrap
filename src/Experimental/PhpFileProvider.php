<?php

declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Finder\FinderInterface;

final class PhpFileProvider
{
    private string $pattern;

    private FinderInterface $finder;

    /**
     * @param string $pattern A glob pattern by which to look up config files.
     */
    public function __construct(string $pattern, FinderInterface $finder)
    {
        $this->pattern = $pattern;
        $this->finder = $finder;
    }

    /**
     * @return \Generator
     */
    public function __invoke(): \Generator
    {
        $this->finder->names([$this->pattern]);
        foreach ($this->finder as $file) {
            yield include $file;
        }
    }
}
