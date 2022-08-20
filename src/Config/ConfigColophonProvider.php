<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Components\Colophon;

class ConfigColophonProvider {

	const COLOPHON = 'colophon';
	const COLOPHON_ACTION = 'colophon_action';
	const COLOPHON_PRIORITY = 'colophon_priority';

	public function __invoke(): iterable {
		yield self::COLOPHON => '';
		yield self::COLOPHON_ACTION => Colophon::EVENT_NAME;
		yield self::COLOPHON_PRIORITY => Colophon::EVENT_PRIORITY;
	}
}
