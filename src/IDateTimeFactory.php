<?php declare(strict_types = 1);

namespace Contributte\Utils;

interface IDateTimeFactory
{

	public function create(string $time = 'now'): DateTime;

}
