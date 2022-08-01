<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigLayoutProvider {

	const POST_CONTENT_TEMPLATE = 'post_content_template';
	const SITE_LAYOUT = 'site_layout';
	const CONTAINER_WIDTH = 'container_width';

	public function __invoke(): iterable {
		yield self::POST_CONTENT_TEMPLATE => '';
		yield self::SITE_LAYOUT => 'content_sidebar';
		yield self::CONTAINER_WIDTH => 'container';
	}
}
