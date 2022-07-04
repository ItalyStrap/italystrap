<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

interface ComponentInterface {

	const DISPLAY_METHOD_NAME = 'display';

	public function shouldLoad(): bool;

	public function display(): void;
}
