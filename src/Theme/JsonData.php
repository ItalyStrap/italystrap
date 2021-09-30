<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\ThemeJsonGenerator\SectionNames;

final class JsonData
{
	public static function getJsonData(): array {
		return [
			SectionNames::VERSION => 1,
		];
	}
}