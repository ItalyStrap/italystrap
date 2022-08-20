<?php
declare(strict_types=1);

namespace ItalyStrap\Navigation;

interface NavMenuLocationInterface {
	public function has(string $location): bool;

	public function register(string $location, string $description): void;

	public function registerMany(array $locations): void;

	public function unregister(string $location): bool;

	public function toArray(): array;
}
