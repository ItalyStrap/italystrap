<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

interface ThumbnailsInterface {

	/**
	 * @param string $name
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @return Thumbnails
	 */
	public function addSize( string $name, int $width = 0, int $height = 0, bool $crop = false  );

	/**
	 * @param string $name
	 * @return Thumbnails
	 */
	public function removeSize( string $name );

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSize( string $name );
}