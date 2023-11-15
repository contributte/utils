<?php declare(strict_types = 1);

namespace Contributte\Utils;

class Urls
{

	public static function hasFragment(string $url): bool
	{
		return str_contains($url, '#');
	}

}
