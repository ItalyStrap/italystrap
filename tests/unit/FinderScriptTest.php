<?php

use ItalyStrap\View\Exceptions\ViewNotFoundException;

class FinderScriptTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

	private function getInstance(  ) {
		$sut = new class extends \ItalyStrap\Finder\AbstractFinder {

			/**
			 * @var string
			 */
			protected $separator = '.';

			/**
			 * @inheritDoc
			 */
			public function find( $slugs, $extension = 'css' ): string {

				$this->assertDirsIsNotEmpty();

				$slugs = (array) $slugs;

				$files = [];
				$this->generateSlugs( $slugs, $files, $extension );

				$this->assertHasFile( $files );

				return $this->files[ $this->generateKey( $files[0] ) ];
			}

			/**
			 * Check if the file exists and is readable
			 *
			 * @param array $files File(s) to search for, in order.
			 * @return bool        Return true if a file exists
			 */
			protected function has( array $files ): bool {

				$key = $this->generateKey( $files[0] );

				if ( empty( $this->files[ $key ] ) ) {
					$this->files[ $key ] = $this->filter( $files );
				}

				return \is_readable( $this->files[ $key ] );
			}

			/**
			 * Generate slugs from given array of names
			 * [ 'content', 'name', 'otherName' ]
			 *
			 * [
			 * 	'content-name-otherName.php',
			 * 	'content-name.php',
			 * 	'content.php',
			 * ]
			 *
			 * @param array $slugs
			 * @param array $files
			 * @param $extensions
			 */
			protected function generateSlugs( array $slugs, array &$files, $extensions ): void {

				foreach ( (array) $extensions as $extension ) {
					$url = '';

					foreach ( $slugs as $slug ) {
						$url .= $this->separator . $slug;
					}

					$url .= '.' . $extension;

					$files[] = \ltrim( $url, $this->separator );
				}

				if ( \count( $slugs ) > 1 ) {
					\array_pop( $slugs );
					$this->generateSlugs( $slugs, $files, $extensions );
				}
			}

			/**
			 *
			 */
			protected function assertDirsIsNotEmpty(): void {
				codecept_debug($this->dirs);
				if ( 0 === \count( $this->dirs ) ) {
					throw new \LogicException( 'You must call ::in() method before calling ::find() method.' );
				}
			}

			/**
			 * @param array $files
			 */
			protected function assertHasFile( array $files ): void {
				if ( !$this->has( $files ) ) {
					throw new ViewNotFoundException(
						\sprintf( 'The file %s does not exists', $files[ 0 ] )
					);
				}
			}

			/**
			 * @inheritDoc
			 */
			protected function filter( array $files ) {

				foreach ( $files as $file ) {
					foreach ( $this->dirs as $dir ) {
						codecept_debug($dir);
						$dir = \rtrim( $dir, '/\\' );
						$temp_file = $dir . \DIRECTORY_SEPARATOR . $file;
						// We need this for Windows and Linux compatibility
						$temp_file = \str_replace( ['/', '\\'], \DIRECTORY_SEPARATOR, $temp_file );
						if ( \is_readable( $temp_file ) ) {
							return $temp_file;
						}
					}
				}

				return '';
			}
		};
		$this->assertInstanceOf(\ItalyStrap\Finder\FinderInterface::class, $sut, '');
		$this->assertInstanceOf(\ItalyStrap\Finder\AbstractFinder::class, $sut, '');
		return $sut;
    }

	/**
	 * @test
	 */
	public function instamceOk() {
		$sut = $this->getInstance();
    }

	/**
	 *
	 */
	public function checkHierarchy() {
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

//		$file = $sut->find(['old', 'min'], 'css');
		$file = $sut->find(['style', 'min'], 'css');
		codecept_debug(PHP_EOL);
		codecept_debug($file);
		codecept_debug(\file_get_contents($file));
    }
}