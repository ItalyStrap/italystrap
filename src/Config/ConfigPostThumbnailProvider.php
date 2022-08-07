<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigPostThumbnailProvider {

	const POST_THUMBNAIL_SIZE = 'post_thumbnail_size';
	const POST_THUMBNAIL_ALIGNMENT = 'post_thumbnail_alignment';

	const POST_THUMBNAIL_SIZE_DEFUALT = 'post-thumbnail';

	const POST_THUMBNAIL_ALIGN_NONE = 'alignnone';
	const POST_THUMBNAIL_ALIGN_FULL = 'alignfull';
	const POST_THUMBNAIL_ALIGN_LEFT = 'alignleft';
	const POST_THUMBNAIL_ALIGN_RIGHT = 'alignright';

	public function __invoke(): iterable {
		yield self::POST_THUMBNAIL_SIZE => self::POST_THUMBNAIL_SIZE_DEFUALT;
		yield self::POST_THUMBNAIL_ALIGNMENT => self::POST_THUMBNAIL_ALIGN_FULL;
	}
}
