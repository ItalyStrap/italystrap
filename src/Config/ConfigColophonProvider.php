<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

class ConfigColophonProvider {

	const COLOPHON = 'colophon';
	const COLOPHON_ACTION = 'colophon_action';
	const COLOPHON_PRIORITY = 'colophon_priority';

	public function __invoke(): iterable {
		yield self::COLOPHON => '';
		yield self::COLOPHON_ACTION => 'italystrap_footer';
		yield self::COLOPHON_PRIORITY => 20;
	}
}
