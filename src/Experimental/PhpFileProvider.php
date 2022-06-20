<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Finder\FinderInterface;

final class PhpFileProvider
{

    /** @var string */
    private $pattern;

    private FinderInterface $finder;

    /**
     * @param string $pattern A glob pattern by which to look up config files.
     */
    public function __construct( string $pattern, FinderInterface $finder )
    {
        $this->pattern = $pattern;
        $this->finder = $finder;
    }

    /**
     * @return \Generator
     */
    public function __invoke(): \Generator
    {
        $this->finder
            ->in(
                [
                    /**
                     * To remember:
                     * This is the correct hierarchy to load and override
                     * the parent with child config.
                     * @see get_config_file_content
                     */
                    get_template_directory(),
                    get_stylesheet_directory(),
                ]
            );

        $this->finder->names([$this->pattern]);
        foreach ($this->finder as $file) {
            yield include $file;
        }
    }
}