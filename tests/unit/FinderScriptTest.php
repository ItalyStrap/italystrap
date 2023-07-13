<?php

declare(strict_types=1);

namespace ItalyStrap\Tests\Unit;

use ItalyStrap\Finder\FileInfoFactory;
use ItalyStrap\Finder\FilesHierarchyIterator;
use ItalyStrap\Finder\Finder;
use ItalyStrap\Tests\UnitTestCase;

use function codecept_data_dir;

class FinderScriptTest extends UnitTestCase
{
    protected function getInstance(): Finder
    {
        $sut = new Finder(
            new FilesHierarchyIterator(
                new FileInfoFactory()
            )
        );
        return $sut;
    }

    /**
     * @test
     */
    public function checkHierarchy()
    {
        $sut = $this->getInstance();
        $sut->in(
            [
                codecept_data_dir('fixtures/deprecated'),
                codecept_data_dir('fixtures/child-assets/src'),
                codecept_data_dir('fixtures/child-assets'),
                codecept_data_dir('fixtures/parent-assets/src'),
                codecept_data_dir('fixtures/parent-assets'),
            ]
        );

        $file = $sut->firstFile(['old', 'min'], 'css');
        $file = $sut->firstFile(['style', 'min'], 'css');
//      codecept_debug(PHP_EOL);
//      codecept_debug($file);
//      codecept_debug(\file_get_contents($file->getRealPath()));
    }
}
