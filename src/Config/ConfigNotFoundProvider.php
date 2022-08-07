<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Customizer\NotFoundFields;

class ConfigNotFoundProvider {

	const SHOW_IMAGE = '404_show_image';
	const ID_IMAGE = '404_image';
	const TITLE = '404_title';
	const CONTENT = '404_content';

	public function __invoke(): iterable {
		yield self::SHOW_IMAGE => NotFoundFields::SHOW_IMAGE;
		yield self::ID_IMAGE => 0;
		yield self::TITLE => \esc_attr__( 'Nothing Found', 'italystrap' );
		yield self::CONTENT => \esc_attr__(
			'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
			'italystrap'
		);
	}
}
